<?php declare(strict_types=1);

namespace App\Shared\Domain\Logging\Attribute;

enum Level: string
{
    /**
     * Detailed information for diagnosing application behavior.
     */
    case DEBUG = 'debug';

    /**
     * General information about normal application activity.
     */
    case INFO = 'info';

    /**
     * Significant events that are not errors.
     */
    case NOTICE = 'notice';

    /**
     * An unusual condition that may require attention.
     */
    case WARNING = 'warning';

    /**
     * An error that prevents an operation from completing successfully.
     */
    case ERROR = 'error';

    /**
     * A serious error that may require immediate investigation.
     */
    case CRITICAL = 'critical';

    /**
     * A condition that requires urgent attention.
     */
    case ALERT = 'alert';

    /**
     * A severe failure that may make the application or system unavailable.
     */
    case EMERGENCY = 'emergency';
}
