<?php

namespace Joyarkdev\JoyarkServices\Models;

use Illuminate\Database\Eloquent\Model;
use Joyarkdev\JoyarkServices\Enums\AppReviewVisitRecordStatus;
use Joyarkdev\JoyarkServices\Enums\AppReviewVisitRecordType;

/**
 * App\Models\AppReviewVisitRecord
 *
 * @property int $id
 * @property AppReviewVisitRecordType $type
 * @property string $value
 * @property string|null $app_id
 * @property string|null $version
 * @property string|null $visit_time
 * @property int $visit_count
 * @property AppReviewVisitRecordStatus $status
 * @property array|null $operator
 * @property string|null $operation_time
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder|AppReviewVisitRecord newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AppReviewVisitRecord newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AppReviewVisitRecord query()
 * @method static \Illuminate\Database\Eloquent\Builder|AppReviewVisitRecord whereAppId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppReviewVisitRecord whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppReviewVisitRecord whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppReviewVisitRecord whereOperationTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppReviewVisitRecord whereOperator($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppReviewVisitRecord whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppReviewVisitRecord whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppReviewVisitRecord whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppReviewVisitRecord whereValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppReviewVisitRecord whereVersion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppReviewVisitRecord whereVisitCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppReviewVisitRecord whereVisitTime($value)
 *
 * @mixin \Eloquent
 */
class AppReviewVisitRecord extends Model
{
    protected $table = 'app_review_visit_records';

    protected $fillable = [
        'type',
        'value',
        'status',
        'operator',
        'operation_time',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'type' => AppReviewVisitRecordType::class,
        'status' => AppReviewVisitRecordStatus::class,
        'operator' => 'json',
    ];
}
