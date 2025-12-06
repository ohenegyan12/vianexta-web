# Buyer Marketplace Implementation Guide

## Overview
This document outlines the key API endpoints from `swagger.json` that should be used to implement the buyer marketplace in the new frontend, based on the existing implementation in `coffee-plug-frontend-vianexta_1.8`.

## Key Endpoints for Buyer Marketplace

### 1. **Product Listing & Search**

#### GET `/api/stock-postings`
**Purpose**: Fetch stock postings (products) with optional filters
**Used in**: `BuyerController::buyer_market_place()`, `BuyerController::new_buyer_wizard()`

**Query Parameters**:
- `productType` (string, optional): Filter by product type
  - Values: `roasted_single_origin`, `roasted_blend`, `green`, `whole_sale_brand`
- `originCountry` (string, optional)
- `process` (string, optional)
- `coffeeType` (string, optional)
- `variety` (string, optional)
- `qualityScoreLowerBound` (number, optional)
- `qualityScoreUpperBound` (number, optional)
- `isSpecialty` (boolean, optional)
- `producedBy` (string, optional)

**Response**: `StatusDto` with `data` containing array of `StockPostingDto`

**Example Usage**:
```typescript
// Get roasted single origin products
GET /api/stock-postings?productType=roasted_single_origin

// Get green beans
GET /api/stock-postings?productType=green

// Get wholesale brands
GET /api/stock-postings?productType=whole_sale_brand
```

#### GET `/api/stock-postings-search-all`
**Purpose**: Search all stock postings by query string
**Used in**: `ProductController::search_product()`

**Query Parameters**:
- `searchQuery` (string, **required**)

**Response**: `StatusDto` with `data` containing array of `StockPostingDto`

#### GET `/api/stock-posting/{id}`
**Purpose**: Get a single stock posting by ID
**Used in**: Product detail pages

**Path Parameters**:
- `id` (integer, required)

**Response**: `StatusDto` with `data` containing `StockPostingDto`

#### GET `/api/most-popular-stock-postings`
**Purpose**: Get most popular stock postings
**Used in**: `BuyerController::buyer_account_page()`

**Response**: `StatusDto` with `data` containing array of `StockPostingDto`

#### GET `/api/stock-postings-by-supplier/{supplierId}`
**Purpose**: Get stock postings for a specific supplier/brand
**Used in**: `BuyerController::buyer_brand_market_place()`

**Path Parameters**:
- `supplierId` (integer, required)

**Response**: `StatusDto` with `data` containing array of `StockPostingDto`

#### GET `/api/filter-options-stock-postings`
**Purpose**: Get available filter options for stock postings
**Used in**: `BuyerController::buyer_market_place()`, `BuyerController::new_buyer_wizard()`

**Response**: `StatusDto` with `data` containing filter options

---

### 2. **Cart Management**

#### GET `/api/all-cart-items`
**Purpose**: Get all items in the cart
**Used in**: `BuyerController::new_buyer_wizard()` (for cart count)

**Response**: `StatusDto` with `data` containing array of cart items

#### POST `/api/cart-item`
**Purpose**: Add item to cart
**Used in**: Adding products to cart from marketplace

**Request Body**: Object with cart item details
```json
{
  "stockPostingId": 123,
  "quantity": 5,
  "bagSize": "12oz",
  "roastType": "medium",
  "grindType": "whole_bean",
  "bagImage": "base64_string",
  "isRoast": true
}
```

**Response**: `StatusDto`

#### PUT `/api/cart-item`
**Purpose**: Edit/update item in cart
**Used in**: Updating cart item quantities or details

**Request Body**: Object with updated cart item details

**Response**: `StatusDto`

#### DELETE `/api/cart-item/{stockPostingId}`
**Purpose**: Remove a specific item from cart

**Path Parameters**:
- `stockPostingId` (integer, required)

**Response**: `StatusDto`

#### DELETE `/api/all-cart-items`
**Purpose**: Clear all items from cart

**Response**: `StatusDto`

#### GET `/api/get-cart-price-breakdown`
**Purpose**: Get price breakdown for cart items
**Used in**: Cart/checkout pages

**Response**: `StatusDto` with `data` containing price breakdown

---

### 3. **Checkout & Orders**

#### POST `/api/checkout-cart`
**Purpose**: Checkout cart items
**Used in**: Finalizing purchase

**Request Body**: Object with checkout details
```json
{
  "paymentType": "paypal",
  "delivery": true,
  // ... other checkout details
}
```

**Response**: `StatusDto`

#### POST `/api/select-delivery-quote`
**Purpose**: Select a delivery quote for an order

**Request Body**: `DeliveryQuoteSelectionDto`
```json
{
  "totalOrderId": 123,
  "quoteId": "quote_123",
  "totalAmount": 150.00,
  "paymentType": "paypal"
}
```

**Response**: `StatusDto`

#### POST `/api/delivery-quotes`
**Purpose**: Get delivery quotes for an order

**Request Body**: `DeliveryQuoteRequestDto`
```json
{
  "orderId": 123,
  "totalWeight": 50.5,
  "length": 10,
  "height": 8,
  "insuranceAmount": 1000
}
```

**Response**: `StatusDto` with `data` containing delivery quotes

---

### 4. **Order Management**

#### GET `/api/order-lists`
**Purpose**: Get list of orders for the buyer
**Used in**: Order history pages

**Response**: `StatusDto` with `data` containing array of orders

#### GET `/api/paid-orders`
**Purpose**: Get paid orders
**Used in**: Order history filtering

**Response**: `StatusDto` with `data` containing array of paid orders

#### GET `/api/unpaid-orders`
**Purpose**: Get unpaid orders
**Used in**: Order history filtering

**Response**: `StatusDto` with `data` containing array of unpaid orders

#### GET `/api/orders-by-payment-status`
**Purpose**: Get orders filtered by payment status

**Query Parameters**:
- `paymentStatus` (string, required)

**Response**: `StatusDto` with `data` containing array of orders

#### GET `/api/get-order-status`
**Purpose**: Get status of a specific order

**Query Parameters**:
- `lotOrderId` (integer, required)

**Response**: `StatusDto` with `data` containing order status

#### GET `/api/get-shipment-status`
**Purpose**: Get shipment status for an order

**Query Parameters**:
- `lotOrderId` (integer, required)

**Response**: `StatusDto` with `data` containing shipment status

#### GET `/api/get-delivery-status`
**Purpose**: Get delivery status for an order

**Query Parameters**:
- `lotOrderId` (integer, required)

**Response**: `StatusDto` with `data` containing delivery status

---

### 5. **Buyer Profile**

#### GET `/api/buyer-profile`
**Purpose**: Get buyer profile information
**Used in**: Account/profile pages

**Response**: `StatusDto` with `data` containing `BuyerDto`

#### PUT `/api/buyer-profile`
**Purpose**: Update buyer profile

**Request Body**: `BuyerDto`

**Response**: `StatusDto`

---

### 6. **Product Details & History**

#### GET `/api/product-history/{id}`
**Purpose**: Get purchase history for a product

**Path Parameters**:
- `id` (integer, required) - stock posting ID

**Response**: `StatusDto` with `data` containing product history

---

### 7. **Wholesale Brands**

#### GET `/api/whole_sale_brands`
**Purpose**: Get list of wholesale brands
**Used in**: `BuyerController::buyer_whole_market_place()`

**Response**: `StatusDto` with `data` containing array of brands

---

## Implementation Recommendations

### For the New Frontend (React/TypeScript)

1. **Create API Service Layer**
   - Create a `services/api.ts` file with functions for each endpoint
   - Use the base URL from swagger: `https://coffeeplug-api-b982ba0e7659.herokuapp.com/api`
   - Handle authentication tokens (likely stored in localStorage after login)

2. **Key Components to Implement**
   - **Marketplace/Product List**: Use `GET /api/stock-postings` with `productType` filter
   - **Product Details**: Use `GET /api/stock-posting/{id}`
   - **Cart**: Use cart endpoints (`GET`, `POST`, `PUT`, `DELETE /api/cart-item`)
   - **Checkout**: Use `POST /api/checkout-cart` and delivery quote endpoints
   - **Order History**: Use order listing endpoints

3. **Product Types to Support** (based on existing implementation)
   - `roasted_single_origin` - Single origin roasted coffee
   - `roasted_blend` - Blended roasted coffee
   - `green` - Green coffee beans
   - `whole_sale_brand` - Wholesale brand products

4. **Wizard Flow** (based on `BuyerWizard.tsx`)
   - Step 1: Select product type (roasted vs wholesale)
   - Step 2: Select coffee type (single-origin vs blend) if roasted
   - Step 3: Select specific product
   - Step 4: Configure options (roast type, grind type, bag size)
   - Step 5: Add to cart or checkout

5. **Filtering & Search**
   - Use `GET /api/filter-options-stock-postings` to get available filters
   - Use `GET /api/stock-postings` with query parameters for filtering
   - Use `GET /api/stock-postings-search-all` for search functionality

## Authentication

Based on `SignIn.tsx`, authentication appears to work as follows:
- Login endpoint: `POST /api/login`
- Token stored in `localStorage` as `authToken`
- User data stored in `localStorage` as `user`
- Include token in API requests (likely as Bearer token or in headers)

## Notes from Existing Implementation

1. The old frontend uses session-based auth (`session('auth_user_tokin')`)
2. The new frontend should use token-based auth (from localStorage)
3. The wizard implementation in `BuyerWizard.tsx` doesn't currently make API calls - it needs to be connected to these endpoints
4. Cart management is a key feature - ensure proper state management for cart items
5. The old frontend has pagination logic in `get_wizard_products()` - consider implementing similar pagination

## Next Steps

1. Create API service functions for all endpoints
2. Implement product listing component with filters
3. Implement product detail view
4. Implement cart functionality
5. Implement checkout flow
6. Connect wizard to API endpoints
7. Add order history/management
8. Implement search functionality

