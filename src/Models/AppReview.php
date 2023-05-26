<?php

namespace Joyarkdev\JoyarkServices\Models;

use Illuminate\Database\Eloquent\Model;
use Joyarkdev\JoyarkServices\Enums\AppReviewStatus;

/**
 * App\Models\AppReview
 *
 * @property int $id
 * @property int $rank
 * @property string $app_id
 * @property string $app_name
 * @property string $version
 * @property AppReviewStatus $status
 * @property string|null $remark
 * @property string|null $charge_text
 * @property string|null $charge_url
 * @property string|null $download_link
 * @property string|null $black_list_countries
 * @property string|null $white_list_countries
 * @property array|null $operator
 * @property string|null $operation_time
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|AppReview newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AppReview newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AppReview query()
 * @method static \Illuminate\Database\Eloquent\Builder|AppReview whereAppId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppReview whereAppName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppReview whereBlackListCountries($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppReview whereChargeText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppReview whereChargeUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppReview whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppReview whereDownloadLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppReview whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppReview whereOperationTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppReview whereOperator($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppReview whereRank($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppReview whereRemark($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppReview whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppReview whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppReview whereVersion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppReview whereWhiteListCountries($value)
 * @mixin \Eloquent
 */
class AppReview extends Model
{
    protected $table = 'app_review';

    protected $fillable = [
        'rank',
        'app_id',
        'app_name',
        'version',
        'status',
        'remark',
        'charge_text',
        'charge_url',
        'download_link',
        'black_list_countries',
        'white_list_countries',
        'operator',
        'operation_time',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'status' => AppReviewStatus::class,
        'operator' => 'json',
    ];
}
