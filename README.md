<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Cart Calculator

### Overview

Develop a versatile program that prices a cart of products, considering various factors such as country-specific shipping fees, product offers, and applicable discounts. The program should be able to handle multiple products, apply different offers dynamically, and generate a comprehensive invoice in USD.

### Technology Stack

-   **Language**: PHP
-   **Programming Paradigm**: Object-Oriented Programming (OOP)
-   **Design Principles**: SOLID
-   **Design Patterns**: Pre-defined design patterns as applicable







### Product Catalog 
The catalog includes products with the following details:
 | Item Type | Item Price (USD) | Shipped From | Weight (kg) | 
 |------------|-------------------|--------------|-------------|
  | T-shirt | $30.99 | US | 0.2 |
   | Blouse | $10.99 | UK | 0.3 | 
  | Pants | $64.99 | UK | 0.9 | 
  | Sweatpants | $84.99 | CN | 1.1 | 
  | Jacket | $199.99 | US | 2.2 |
   | Shoes | $79.99 | CN | 1.3 |


### Offers and Discounts

The program supports dynamic application of discounts and offers, including:

-   **User-Defined Discounts**: Allows users to apply custom percentage-based or fixed amount discounts to individual items or the entire cart.
-   **Offers**: Users can specify promotional offers, such as discounts on specific products or combinations of products.


### Shipping Rates

Shipping fees are calculated based on the weight of each item and the shipping country. Rates are defined as:
#### Shipping Rates The shipping rates are as follows: 
| Country | Rate (USD per 100 grams) | 
|---------|---------------------------|
 | US | $2 |
  | UK | $3 |
   | CN | $2 |


### VAT

A 14% VAT is applied to the subtotal (sum of item prices) before any user-defined discounts or offers are applied.

### Invoice Output

The program generates a detailed invoice including:

1.  **Subtotal**: Total of all item prices.
2.  **Shipping Fees**: Calculated based on weight and shipping country rates.
3.  **VAT**: 14% VAT applied to the subtotal before discounts.
4.  **Discounts**: Detailed breakdown of any user-defined discounts and offers applied.
5. **Total**: Final amount after applying all discounts, VAT, and shipping fees
### Flexibility and Adjustments

The system is designed to:

-   Allow users to define and apply various discounts and offers dynamically.
-   Adjust calculations based on changes in item prices, weights, shipping rates, or VAT rates.
-   Accommodate different scenarios and promotions as specified by users.

This approach ensures a robust, scalable, and maintainable system that meets diverse and evolving requirements.

**e.g.**

Adding the following products:

```
T-shirt
Blouse
Pants
Shoes
Jacket

```

Outputs the following invoice:

```
Subtotal: $386.95
Shipping: $110
VAT: $54.173
Discounts:
	10% off shoes: -$7.999
	50% off jacket: -$99.995
	$10 of shipping: -$10
Total: $433.129
```

