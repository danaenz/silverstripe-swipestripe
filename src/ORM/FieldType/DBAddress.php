<?php
declare(strict_types=1);

namespace SwipeStripe\ORM\FieldType;

use SilverStripe\Forms\FieldGroup;
use SilverStripe\Forms\TextField;
use SilverStripe\i18n\Data\Intl\IntlLocales;
use SilverStripe\ORM\FieldType\DBComposite;
use SilverStripe\ORM\FieldType\DBVarchar;
use SwipeStripe\Forms\Fields\CountryDropdownField;

/**
 * Class DBAddress
 * @package SwipeStripe\ORM\FieldType
 * @property string $Unit
 * @property string $Street
 * @property string $Suburb
 * @property string $City
 * @property string $Region
 * @property string $Postcode
 * @property string $Country
 */
class DBAddress extends DBComposite
{
    /**
     * @var array
     */
    private static $composite_db = [
        'Unit'     => DBVarchar::class,
        'Street'   => DBVarchar::class,
        'Suburb'   => DBVarchar::class,
        'City'     => DBVarchar::class,
        'Region'   => DBVarchar::class,
        'Postcode' => DBVarchar::class,
        'Country'  => DBVarchar::class,
    ];

    /**
     * @return string
     */
    public function Nice(): string
    {
        $address = '';

        if (!empty($this->Unit) || !empty($this->Street)) {
            $address .= trim("{$this->Unit} {$this->Street}") . ",\n";
        }

        if (!empty($this->Suburb)) {
            $address .= "{$this->Suburb},\n";
        }

        if (!empty($this->City)) {
            $address .= "{$this->City},\n";
        }

        if (!empty($this->Region)) {
            $address .= "{$this->Region},\n";
        }

        if (!empty($this->Country)) {
            $address .= IntlLocales::singleton()->countryName($this->Country) . ' ';
        }

        if (!empty($this->Postcode)) {
            $address .= $this->Postcode;
        }

        return rtrim($address);
    }

    /**
     * @param DBAddress $other
     * @return $this
     */
    public function copyFrom(DBAddress $other): self
    {
        $this->Unit = $other->Unit;
        $this->Street = $other->Street;
        $this->Suburb = $other->Suburb;
        $this->City = $other->City;
        $this->Region = $other->Region;
        $this->Postcode = $other->Postcode;
        $this->Country = $other->Country;

        return $this;
    }

    /**
     * @param array $data
     * @param string $fieldName
     * @return DBAddress
     */
    public function copyFromArray(array $data, string $fieldName = ''): self
    {
        $this->Unit = $data["{$fieldName}Unit"];
        $this->Street = $data["{$fieldName}Street"];
        $this->Suburb = $data["{$fieldName}Suburb"];
        $this->City = $data["{$fieldName}City"];
        $this->Region = $data["{$fieldName}Region"];
        $this->Postcode = $data["{$fieldName}Postcode"];
        $this->Country = $data["{$fieldName}Country"];

        return $this;
    }

    /**
     * @return bool
     */
    public function Empty(): bool
    {
        return empty($this->Unit) && empty($this->Street) && empty($this->Suburb) && empty($this->City) &&
            empty($this->Region) && empty($this->Postcode) && empty($this->Country);
    }

    /**
     * @inheritDoc
     */
    public function scaffoldFormField($title = null, $params = null)
    {
        return FieldGroup::create($title ?? FieldGroup::name_to_label($this->getName()), [
            TextField::create("{$this->getName()}Unit", 'Unit'),
            TextField::create("{$this->getName()}Street", 'Street'),
            TextField::create("{$this->getName()}Suburb", 'Suburb'),
            TextField::create("{$this->getName()}City", 'City'),
            TextField::create("{$this->getName()}Region", 'Region'),
            TextField::create("{$this->getName()}Postcode", 'Post Code / Zip'),
            CountryDropdownField::create("{$this->getName()}Country", 'Country'),
        ]);
    }
}
