<?php namespace nl\rabobank\gict\payments_savings\omnikassa_sdk\model;

use JsonSerializable;
use nl\rabobank\gict\payments_savings\omnikassa_sdk\model\signing\SignatureDataProvider;

class OrderItem implements JsonSerializable, SignatureDataProvider
{
    /** @var string */
    private $id;
    /** @var string */
    private $name;
    /** @var string */
    private $description;
    /** @var int */
    private $quantity;
    /** @var Money */
    private $amount;
    /** @var Money */
    private $tax;
    /** @var string */
    private $category;
    /** @var string */
    private $vatCategory;

    /**
     * @param string $name
     * @param string $description
     * @param int $quantity describes how many of this item the customer ordered
     * @param Money $amount describes the price per item
     * @param Money $tax describes the tax per item
     * @param string $category
     * @deprecated
     * @see OrderItem::createFrom() to create instances of order items.
     */
    public function __construct($name, $description, $quantity, $amount, $tax, $category)
    {
        $this->name = $name;
        $this->description = $description;
        $this->quantity = $quantity;
        $this->amount = $amount;
        $this->tax = $tax;
        $this->category = $category;
    }

    /**
     * Create an {@link OrderItem} from the given data array.
     *
     * Example:
     * <code>
     * $orderItem = OrderItem::createFrom([
     *     "id" => "15",
     *     "name" => "Name",
     *     "description" => "Description",
     *     "quantity" => 1,
     *     "amount" => Money::fromCents('EUR', 100),
     *     "tax" => Money::fromCents('EUR', 50),
     *     "category" => ProductType::DIGITAL,
     *     "vatCategory" => VatCategory::LOW
     * ]);
     * </code>
     *
     * Example without optional fields:
     * <code>
     * OrderItem::createFrom([
     *     "name" => "Name",
     *     "description" => "Description",
     *     "quantity" => 1,
     *     "amount" => Money::fromCents('EUR', 100),
     *     "category" => ProductType::DIGITAL
     * ]);
     * </code>
     * @param array $data
     * @return OrderItem
     */
    public static function createFrom(array $data)
    {
        $orderItem = new OrderItem(null, null, null, null, null, null);
        foreach ($orderItem as $key => $value) {
            if (array_key_exists($key, $data)) {
                $orderItem->$key = $data["$key"];
            }
        }
        return $orderItem;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @return Money
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @return Money
     */
    public function getTax()
    {
        return $this->tax;
    }

    /**
     * @return string
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @return string
     */
    public function getVatCategory()
    {
        return $this->vatCategory;
    }

    /**
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     */
    public function jsonSerialize()
    {
        $json = array();
        foreach ($this as $key => $value) {
            if ($value != null) {
                $json[$key] = $value;
            }
        }
        return $json;
    }

    public function getSignatureData()
    {
        $data = [];
        if ($this->id != null) {
            $data[] = $this->id;
        }
        $data[] = $this->name;
        $data[] = $this->description;
        $data[] = $this->quantity;
        $data[] = $this->amount->getSignatureData();
        $data[] = ($this->tax != null ? $this->tax->getSignatureData() : null);
        $data[] = $this->category;
        if ($this->vatCategory != null) {
            $data[] = $this->vatCategory;
        }
        return $data;
    }
}