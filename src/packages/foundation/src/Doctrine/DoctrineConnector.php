<?php declare(strict_types=1);

namespace Foundation\Doctrine;

use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMSetup;
use Doctrine\ORM\Proxy\ProxyFactory;
use Foundation\Doctrine\Auth\DoctrineAuthenticator;
use Foundation\Doctrine\Auth\AuthenticatorInterface;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Cache\Adapter\RedisAdapter;

final class DoctrineConnector extends ServiceProvider
{
    /**
     * @return void
     */
    public function register(): void
    {
        $this->app->singleton(
            abstract: EntityManagerInterface::class,
            concrete: function (Application $app): EntityManager {
                $redis = RedisAdapter::createConnection(
                    dsn: config(key: 'doctrine.redis_url'),
                    options: config(key: 'doctrine.redis_ssl_options', default: [])
                );

                $proxyDir = storage_path(path: 'doctrine/proxies');

                if (!is_dir(filename: $proxyDir)) {
                    mkdir(directory: $proxyDir, permissions: 0775, recursive: true);
                }

                $config = ORMSetup::createAttributeMetadataConfiguration(
                    paths: config(key: 'doctrine.metadata_dirs'),
                    isDevMode: config(key: 'doctrine.dev_mode'),
                    proxyDir: $proxyDir,
                    cache: new RedisAdapter(redis: $redis)
                );

                $config->setAutoGenerateProxyClasses(
                    autoGenerate: ProxyFactory::AUTOGENERATE_ALWAYS
                );

                if (config(key: 'doctrine.orm.enable_native_lazy_objects', default: false)) {
                    $config->enableNativeLazyObjects(nativeLazyObjects: true);
                }

                $connection = DriverManager::getConnection(
                    params: config(key: 'doctrine.connection'),
                    config: $config
                );

                foreach (config(key: 'doctrine.custom_types', default: []) as $type) {
                    [$name, $class] = $type;
                    if (!Type::hasType(name: $name)) {
                        Type::addType(name: $name, type: $class);
                    }
                }

                return new EntityManager(conn: $connection, config: $config);
            }
        );
    }

    /**
     * @return void
     */
    public function boot(): void
    {
        Auth::provider(
            name: 'doctrine',
            callback: function (Application $app, array $config): AuthenticatorInterface {
                return new DoctrineAuthenticator(
                    hasher: $app->make(abstract: 'hash'),
                    model: $config['model']
                );
            }
        );
    }
}
