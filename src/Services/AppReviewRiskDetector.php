<?php

namespace Joyarkdev\JoyarkServices\Services;

use Illuminate\Support\Facades\Log;
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
        Log::info('Start Check');

        return $this->checkWhiteListIp();
    }

    private function checkWhiteListIp(): RiskLevel
    {
        Log::info('Check White List (Ip)');

        $status = AppReviewVisitRecord::whereType(AppReviewVisitRecordType::IP)
            ->whereValue($this->ip)
            ->whereStatus(AppReviewVisitRecordStatus::WHITELIST)
            ->first()
            ->status ?? AppReviewVisitRecordStatus::DEFAULT;

        return match ($status) {
            AppReviewVisitRecordStatus::WHITELIST => RiskLevel::PASS,
            default => $this->checkWhiteListDeviceId(),
        };
    }

    private function checkWhiteListDeviceId(): RiskLevel
    {
        Log::info('Check White List (Device Id)');

        $status = AppReviewVisitRecord::whereType(AppReviewVisitRecordType::DEVICE_ID)
            ->whereValue($this->deviceId)
            ->whereStatus(AppReviewVisitRecordStatus::WHITELIST)
            ->first()
            ->status ?? AppReviewVisitRecordStatus::DEFAULT;

        return match ($status) {
            AppReviewVisitRecordStatus::WHITELIST => RiskLevel::PASS,
            default => $this->checkBlackListIp(),
        };
    }

    private function checkBlackListIp(): RiskLevel
    {
        Log::info('Check Black List (Ip)');

        $status = AppReviewVisitRecord::whereType(AppReviewVisitRecordType::IP)
            ->whereValue($this->ip)
            ->whereStatus(AppReviewVisitRecordStatus::BLACKLIST)
            ->first()
            ->status ?? AppReviewVisitRecordStatus::DEFAULT;

        return match ($status) {
            AppReviewVisitRecordStatus::BLACKLIST => RiskLevel::REJECT,
            default => $this->checkBlackListDeviceId(),
        };
    }

    private function checkBlackListDeviceId(): RiskLevel
    {
        Log::info('Check Black List (Device Id)');

        $status = AppReviewVisitRecord::whereType(AppReviewVisitRecordType::DEVICE_ID)
            ->whereValue($this->deviceId)
            ->whereStatus(AppReviewVisitRecordStatus::BLACKLIST)
            ->first()
            ->status ?? AppReviewVisitRecordStatus::DEFAULT;

        return match ($status) {
            AppReviewVisitRecordStatus::BLACKLIST => RiskLevel::REJECT,
            default => $this->checkApp(),
        };
    }

    private function checkApp(): RiskLevel
    {
        Log::info('Check App');

        $this->app = AppReview::whereAppId($this->appId)->first();

        if (! $this->app) {
            Log::error('App Not Exists');

            return RiskLevel::PASS;
        }

        return $this->checkWhiteListCountries();
    }

    private function checkWhiteListCountries(): RiskLevel
    {
        Log::info('Check White List Countries');

        $this->countryCode = Location::get($this->ip)->countryCode ?? null;

        if (in_array($this->countryCode, explode(',', $this->app->white_list_countries))) {
            return RiskLevel::PASS;
        }

        return $this->checkVersion();
    }

    private function checkVersion(): RiskLevel
    {
        Log::info('Check App Version');

        return match ($this->version <=> $this->app->version) {
            1 => RiskLevel::REVIEW,
            -1 => RiskLevel::PASS,
            0 => $this->checkBlackListCountries(),
        };
    }

    private function checkBlackListCountries(): RiskLevel
    {
        Log::info('Check Black List Countries');

        if (in_array($this->countryCode, explode(',', $this->app->black_list_countries))) {
            return RiskLevel::REVIEW;
        }

        return RiskLevel::PASS;
    }
}
