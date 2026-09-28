<?php declare(strict_types=1);

namespace Foundation\Doctrine\Pagination;

use Doctrine\ORM\Query;
use Doctrine\ORM\Tools\Pagination\Paginator as DoctrinePaginator;
use Doctrine\ORM\Query\Parameter;
use Illuminate\Pagination\LengthAwarePaginator as LaravelLengthAwarePaginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;

/**
 * @template TItem of object
 * @extends LengthAwarePaginator<int, TItem>
 */
final class LengthAwarePaginator extends LaravelLengthAwarePaginator
{
    /**
     * @param Query $query
     * @param int $perPage
     * @param Request|null $request
     */
    public function __construct(
        Query $query,
        int $perPage = 10,
        ?Request $request = null
    ) {
        $request ??= request();

        $currentPage = $this->getCurrentPage(request: $request);
        $total = $this->getTotalCount(query: $query);
        $lastPage = $this->getLastPage(total: $total, perPage: $perPage);
        $currentPage = min($currentPage, $lastPage);

        $this->applyPaginationLimits(
            query: $query,
            currentPage: $currentPage,
            perPage: $perPage
        );

        $paginator = new DoctrinePaginator(query: $query);
        $items = $this->getItems(paginator: $paginator);

        parent::__construct(
            items: collect(value: $items),
            total: $total,
            perPage: $perPage,
            currentPage: $currentPage,
            options: [
                'path' => $request->url(),
                'query' => $request->query(),
            ]
        );
    }

    /**
     * @param Request $request
     * @return int
     */
    private function getCurrentPage(Request $request): int
    {
        return max(1,
            (int) $request->query(key: 'page', default: '1')
        );
    }

    /**
     * @param Query $query
     * @return int
     */
    private function getTotalCount(Query $query): int
    {
        $cacheKey = $this->getCacheKey(query: $query);

        return (int) Cache::remember(
            key: $cacheKey,
            ttl: 60,
            callback: function () use ($query): int {
                $countQuery = clone $query;
                $countQuery->setFirstResult(
                    firstResult: 0
                )->setMaxResults(
                    maxResults: null
                );

                try {
                    $paginator = new DoctrinePaginator(
                        query: $countQuery,
                        fetchJoinCollection: false
                    );

                    return $paginator->count();
                }

                catch (\Exception) {
                    $result = $countQuery->getSingleScalarResult();
                    return (int) array_shift($result);
                }
            }
        );
    }

    /**
     * @param Query $query
     * @return string
     */
    private function getCacheKey(Query $query): string
    {
        $sql = $query->getSQL();

        $params = $query->getParameters()->map(
            func: fn (Parameter $p): mixed => $p->getValue()
        )->toArray();
        
        return 'paginator_count:' . md5(
            string: $sql . ':' . json_encode(value: $params)
        );
    }

    /**
     * @param int $total
     * @param int $perPage
     * 
     * @return int
     */
    private function getLastPage(int $total, int $perPage): int
    {
        return max((int) ceil(
            num: $total / max($perPage, 1)
        ), 1);
    }

    /**
     * @param Query $query
     * @param int $currentPage
     * @param int $perPage
     * 
     * @return int
     */
    private function applyPaginationLimits(
        Query $query, int $currentPage, int $perPage): void
    {
        $query->setFirstResult(
            firstResult: ($currentPage - 1) * $perPage
        )->setMaxResults(
            maxResults: $perPage
        );
    }

    /**
     * @param DoctrinePaginator $paginator
     * @return iterable
     */
    private function getItems(DoctrinePaginator $paginator): iterable
    {
        return $paginator->getIterator();
    }
}
