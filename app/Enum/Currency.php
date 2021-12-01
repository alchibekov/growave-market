<?php

namespace App\Enum;

use InvalidArgumentException;
use MyCLabs\Enum\Enum;

/**
 * @method static static KGS()
 * @method static static USD()
 * @method static static EUR()
 * @method static static RUB()
 * @method static static KZT()
 */
class Currency extends Enum
{
    private const KGS = 'KGS';
    private const USD = 'USD';
    private const EUR = 'EUR';
    private const RUB = 'RUB';
    private const KZT = 'KZT';

    public static function toIdArray(): array
    {
        return [
            1 => self::KGS,
            2 => self::USD,
            3 => self::EUR,
            4 => self::RUB,
            5 => self::KZT,
        ];
    }

    public static function getDefaultCurrencyId(): int
    {
        return (new self(self::KGS))->getId();
    }

    /**
     * @param int|null $id
     * @return static|null
     */
    public static function fromId(?int $id): ?self
    {
        $ids = self::toIdArray();

        return  (isset($ids[$id])) ? new self($ids[$id]) : null;
    }

    /**
     * @return Currency
     */
    public static function default(): Currency
    {
        return self::KGS();
    }

    public function getTitle(): string
    {
        $titles = self::toIdArray();

        return $titles[$this->getId()] ?? '';
    }

    public function getId(): int
    {
        $id = array_search($this->getValue(), self::toIdArray(), true);

        if (false === $id) {
            throw new InvalidArgumentException('Unknown currency: '.$this->getValue());
        }

        return $id;
    }

    public function getIcon(): string
    {
        $icons = self::toIconArray();

        return $icons[$this->getId()] ?? '';
    }

    public static function toIconArray(): array
    {
        return [
            1 => Icon::KGS(),
            2 => Icon::USD(),
            3 => Icon::EUR(),
            4 => Icon::RUB(),
            5 => Icon::KZT(),
       ];
    }
}
