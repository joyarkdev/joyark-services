<?php

namespace Joyarkdev\JoyarkServices\Services;

use Joyarkdev\JoyarkServices\Enums\AppReviewVisitRecordStatus;
use Joyarkdev\JoyarkServices\Enums\AppReviewVisitRecordType;
use Joyarkdev\JoyarkServices\Enums\RiskLevel;
use Joyarkdev\JoyarkServices\Models\AppReview;
use Joyarkdev\JoyarkServices\Models\AppReviewVisitRecord;
use Joyarkdev\JoyarkServices\Services\DeveloperPlatform\IpCode;

class AppReviewRiskDetector
{
    private $ip;

    private $deviceId;

    private ?AppReview $app;

    private $countryCode;

    public function checkIp($ip): AppReviewRiskDetector|RiskLevel|static
    {
        $this->ip = $ip;

        $status = AppReviewVisitRecord::whereType(AppReviewVisitRecordType::IP)
                            ->whereValue($ip)
                            ->first()
                            ->status ?? AppReviewVisitRecordStatus::DEFAULT;

        return match ($status) {
            AppReviewVisitRecordStatus::WHITELIST => RiskLevel::PASS,
            AppReviewVisitRecordStatus::BLACKLIST => RiskLevel::REVIEW,
            default => $this,
        };
    }

    public function checkDeviceId($deviceId): AppReviewRiskDetector|RiskLevel|static
    {
        $this->deviceId = $deviceId;

        $status = AppReviewVisitRecord::whereType(AppReviewVisitRecordType::DEVICE_ID)
            ->whereValue($deviceId)
            ->first()
            ->status ?? AppReviewVisitRecordStatus::DEFAULT;

        return match ($status) {
            AppReviewVisitRecordStatus::WHITELIST => RiskLevel::PASS,
            AppReviewVisitRecordStatus::BLACKLIST => RiskLevel::REVIEW,
            default => $this,
        };
    }

    public function checkApp($appId): RiskLevel|static
    {
        $this->app = AppReview::whereAppId($appId)->first();

        if (!$this->app) {
            return RiskLevel::PASS;
        }

        return $this;
    }

    public function checkWhiteListCountries(): RiskLevel|static
    {
        $this->countryCode = (new IpCode())->getCountryCodeByIp($this->ip);

        if (in_array($this->countryCode, explode(',', $this->app->white_list_countries))) {
            return RiskLevel::PASS;
        }

        return $this;
    }

    public function checkVersion($version): AppReviewRiskDetector|RiskLevel|static
    {
        return match ($version <=> $this->app->version) {
            1 => RiskLevel::REVIEW,
            -1 => RiskLevel::PASS,
            0 => $this,
        };
    }

    public function checkBlackListCountries(): RiskLevel|static
    {
        if (in_array($this->countryCode, explode(',', $this->app->black_list_countries))) {
            return RiskLevel::REVIEW;
        }

        return $this;
    }

    public function done(): RiskLevel
    {
        return RiskLevel::PASS;
    }
}
