<?php

namespace Joyarkdev\JoyarkServices\Services;

use Joyarkdev\JoyarkServices\Enums\AppReviewVisitRecordStatus;
use Joyarkdev\JoyarkServices\Enums\AppReviewVisitRecordType;
use Joyarkdev\JoyarkServices\Enums\RiskLevel;
use Joyarkdev\JoyarkServices\Models\AppReview;
use Joyarkdev\JoyarkServices\Models\AppReviewVisitRecord;
use Stevebauman\Location\Facades\Location;

class AppReviewRiskDetector
{
    private $ip;

    private $deviceId;

    private $appId;

    private $version;

    private ?AppReview $app;

    private $countryCode;

    public function setIp($ip): static
    {
        $this->ip = $ip;

        return $this;
    }

    public function setDeviceId($deviceId): static
    {
        $this->deviceId = $deviceId;

        return $this;
    }

    public function setAppId($appId): static
    {
        $this->appId = $appId;

        return $this;
    }

    public function setVersion($version): static
    {
        $this->version = $version;

        return $this;
    }

    public function check(): RiskLevel
    {
        return $this->checkIp();
    }

    private function checkIp(): RiskLevel
    {
        $status = AppReviewVisitRecord::whereType(AppReviewVisitRecordType::IP)
            ->whereValue($this->ip)
            ->first()
                            ->status ?? AppReviewVisitRecordStatus::DEFAULT;

        return match ($status) {
            AppReviewVisitRecordStatus::WHITELIST => RiskLevel::PASS,
            AppReviewVisitRecordStatus::BLACKLIST => RiskLevel::REJECT,
            default => $this->checkDeviceId(),
        };
    }

    private function checkDeviceId(): RiskLevel
    {
        $status = AppReviewVisitRecord::whereType(AppReviewVisitRecordType::DEVICE_ID)
            ->whereValue($this->deviceId)
            ->first()
            ->status ?? AppReviewVisitRecordStatus::DEFAULT;

        return match ($status) {
            AppReviewVisitRecordStatus::WHITELIST => RiskLevel::PASS,
            AppReviewVisitRecordStatus::BLACKLIST => RiskLevel::REJECT,
            default => $this->checkApp(),
        };
    }

    private function checkApp(): RiskLevel
    {
        $this->app = AppReview::whereAppId($this->appId)->first();

        if (! $this->app) {
            return RiskLevel::PASS;
        }

        return $this->checkWhiteListCountries();
    }

    private function checkWhiteListCountries(): RiskLevel
    {
        $this->countryCode = Location::get();

        if (in_array($this->countryCode, explode(',', $this->app->white_list_countries))) {
            return RiskLevel::PASS;
        }

        return $this->checkVersion();
    }

    private function checkVersion(): RiskLevel
    {
        return match ($this->version <=> $this->app->version) {
            1 => RiskLevel::REVIEW,
            -1 => RiskLevel::PASS,
            0 => $this->checkBlackListCountries(),
        };
    }

    private function checkBlackListCountries(): RiskLevel
    {
        if (in_array($this->countryCode, explode(',', $this->app->black_list_countries))) {
            return RiskLevel::REJECT;
        }

        return RiskLevel::PASS;
    }
}
