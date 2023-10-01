<?php

/**
 * @OA\Schema(
 *     title="Product",
 *     description="Product model",
 *     @OA\Xml(
 *         name="Product"
 *     )
 * )
 */
class Product
{

    /**
     * @OA\Property(
     *     title="ID",
     *     description="ID",
     *     format="int64",
     *     example=1
     * )
     *
     * @var integer
     */
    private $id;

    /**
     * @OA\Property(
     *      title="Title",
     *      description="Title of the new product",
     *      example="Product Title"
     * )
     *
     * @var string
     */
    public $title;

    /**
     * @OA\Property(
     *      title="Description",
     *      description="Description of the new product",
     *      example="This is new product's description"
     * )
     *
     * @var string
     */
    public $description;

    /**
     * @OA\Property(
     *      title="Price",
     *      description="Price of the new product",
     *      example="10"
     * )
     *
     * @var float
     */
    public $price;

    /**
     * @OA\Property(
     *      title="Promo Price",
     *      description="Promo Price of the new product",
     *      example="7"
     * )
     *
     * @var float
     */
    public $promo_price;

    /**
     * @OA\Property(
     *      title="Brand Id",
     *      description="Brand's id of the new product",
     *      format="int64",
     *      example=1
     * )
     *
     * @var integer
     */
    public $brand_id;

    /**
     * @OA\Property(
     *     title="Brand",
     *     description="Brand of product"
     * )
     *
     * @var Brand
     */
    public $brand;

    /**
     * @OA\Property(
     *     title="Created at",
     *     description="Created at",
     *     example="2020-01-27 17:50:45",
     *     format="datetime",
     *     type="string"
     * )
     *
     * @var \DateTime
     */
    private $created_at;

    /**
     * @OA\Property(
     *     title="Updated at",
     *     description="Updated at",
     *     example="2020-01-27 17:50:45",
     *     format="datetime",
     *     type="string"
     * )
     *
     * @var \DateTime
     */
    private $updated_at;

    /**
     * @OA\Property(
     *     title="Deleted at",
     *     description="Deleted at",
     *     example="2020-01-27 17:50:45",
     *     format="datetime",
     *     type="string"
     * )
     *
     * @var \DateTime
     */
    private $deleted_at;
}