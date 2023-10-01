<?php

/**
 * @OA\Schema(
 *      title="Store Product request",
 *      description="Store Product request body data",
 *      type="object",
 *      required={"title", "brand_id", "price"}
 * )
 */

 class StoreProductRequest
 {
     /**
      * @OA\Property(
      *      title="title",
      *      description="Name of the new product",
      *      example="A nice product"
      * )
      *
      * @var string
      */
     public $title;
 
     /**
      * @OA\Property(
      *      title="description",
      *      description="Description of the new product",
      *      example="This is new product's description"
      * )
      *
      * @var string
      */
     public $description;

     /**
      * @OA\Property(
      *      title="price",
      *      description="Price of the new product",
      *      example=10
      * )
      *
      * @var float
      */
      public $price;

      /**
      * @OA\Property(
      *      title="Promo Price",
      *      description="Promo Price of the new product",
      *      example=0
      * )
      *
      * @var float
      */
     public $promo_price;
 
     /**
      * @OA\Property(
      *      title="brand_id",
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
      *      title="Images",
      *      description="List image's ids of the new product",
      *      format="int64",
      *      example=[1, 2, 3]
      * )
      *
      * @var array
      */
      public $images;


 }