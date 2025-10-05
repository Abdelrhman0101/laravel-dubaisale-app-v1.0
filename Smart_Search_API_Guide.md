# Smart Search API Guide

This guide provides comprehensive documentation for the new smart search endpoints that support multiple values for the same field across all ad categories.

## Overview

The smart search system allows f iltering by multiple values for the same field using comma-separated values or arrays. This enables more flexible and powerful search capabilities.

## Common Features

All smart search endpoints support:
- **Multiple Values**: Use comma-separated values or arrays for the same field
- **Keyword Search**: Search across multiple text fields simultaneously
- **Offers Box Filter**: Filter for ads in the offers box only
- **Sorting Options**: `latest`, `most_viewed`, `rank`
- **Pagination**: Standard Laravel pagination with `per_page` parameter
- **Backward Compatibility**: Legacy single-value filters still work

## 1. Restaurant Ads

### Endpoints
- **GET** `/api/restaurants/search` - Smart search with multiple filters
- **GET** `/api/restaurants/offers-box/ads` - Get active offers box ads

### Search Parameters
- `category` - Restaurant category (multiple values supported)
- `emirate` - Emirates (multiple values supported)
- `district` - Districts (multiple values supported)
- `keyword` - Search in title, description, restaurant_name, emirate, district
- `offers_box_only` - Filter offers box ads only (true/false)
- `sort` - Sorting: `latest`, `most_viewed`, `rank` (default: latest)
- `per_page` - Results per page (default: 15)

### Examples

#### Single Value Search
```
GET /api/restaurants/search?emirate=Dubai&category=Fast Food
```

#### Multiple Values Search
```
GET /api/restaurants/search?emirate=Dubai,Abu Dhabi&category=Fast Food,Italian
```

#### Keyword Search with Filters
```
GET /api/restaurants/search?keyword=pizza&emirate=Dubai,Sharjah&sort=most_viewed
```

#### Offers Box Only
```
GET /api/restaurants/search?offers_box_only=true&per_page=10
```

## 2. Real Estate Ads

### Endpoints
- **GET** `/api/real-estates/search` - Smart search with multiple filters
- **GET** `/api/real-estates/offers-box/ads` - Get active offers box ads

### Search Parameters
- `emirate` - Emirates (multiple values supported)
- `district` - Districts (multiple values supported)
- `area` - Areas (multiple values supported)
- `contract_type` - Contract types: Sale, Rent (multiple values supported)
- `property_type` - Property types (multiple values supported)
- `price_range` - Price ranges (multiple values supported)
- `keyword` - Search in title, description, emirate, district, area
- `offers_box_only` - Filter offers box ads only (true/false)
- `sort` - Sorting: `latest`, `most_viewed`, `rank` (default: latest)
- `per_page` - Results per page (default: 15)

### Examples

#### Property Type and Location Search
```
GET /api/real-estates/search?property_type=Apartment,Villa&emirate=Dubai&district=Downtown,Marina
```

#### Price Range and Contract Type
```
GET /api/real-estates/search?contract_type=Sale&price_range=500000-1000000,1000000-2000000
```

#### Comprehensive Search
```
GET /api/real-estates/search?emirate=Dubai,Abu Dhabi&property_type=Apartment&contract_type=Rent&keyword=sea view&sort=rank
```

## 3. Car Services Ads

### Endpoints
- **GET** `/api/car-services-ads/search` - Smart search with multiple filters
- **GET** `/api/car-services-ads/offers-box/ads` - Get active offers box ads

### Search Parameters
- `service_type` - Service types (multiple values supported)
- `emirate` - Emirates (multiple values supported)
- `district` - Districts (multiple values supported)
- `area` - Areas (multiple values supported)
- `price_range` - Price ranges (multiple values supported)
- `keyword` - Search in title, description, service_name, emirate, district, area
- `offers_box_only` - Filter offers box ads only (true/false)
- `sort` - Sorting: `latest`, `most_viewed`, `rank` (default: latest)
- `per_page` - Results per page (default: 15)

### Examples

#### Service Type and Location
```
GET /api/car-services-ads/search?service_type=Oil Change,Brake Service&emirate=Dubai
```

#### Price Range Filter
```
GET /api/car-services-ads/search?price_range=100-300,300-500&district=Deira,Bur Dubai
```

## 4. Car Rent Ads

### Endpoints
- **GET** `/api/car-rent-ads/search` - Smart search with multiple filters
- **GET** `/api/car-rent-ads/offers-box/ads` - Get active offers box ads

### Search Parameters
- `make` - Car makes (multiple values supported)
- `model` - Car models (multiple values supported)
- `trim` - Car trims (multiple values supported)
- `year` - Car years (multiple values supported)
- `emirate` - Emirates (multiple values supported)
- `district` - Districts (multiple values supported)
- `area` - Areas (multiple values supported)
- `price_range` - General price ranges (multiple values supported)
- `day_rent_range` - Daily rent ranges (multiple values supported)
- `month_rent_range` - Monthly rent ranges (multiple values supported)
- `keyword` - Search in title, description, emirate, district, area
- `offers_box_only` - Filter offers box ads only (true/false)
- `sort` - Sorting: `latest`, `most_viewed`, `rank` (default: latest)
- `per_page` - Results per page (default: 15)

### Examples

#### Car Make and Model Search
```
GET /api/car-rent-ads/search?make=Toyota,Honda&model=Camry,Accord,Civic
```

#### Year and Location Filter
```
GET /api/car-rent-ads/search?year=2020,2021,2022&emirate=Dubai&district=Downtown
```

#### Rent Range Search
```
GET /api/car-rent-ads/search?day_rent_range=50-100,100-200&month_rent_range=1000-2000
```

## 5. Job Ads

### Endpoints
- **GET** `/api/jobs/search` - Smart search with multiple filters
- **GET** `/api/jobs/offers-box/ads` - Get active offers box ads

### Search Parameters
- `emirate` - Emirates (multiple values supported)
- `district` - Districts (multiple values supported)
- `category_type` - Job categories (multiple values supported)
- `section_type` - Job sections (multiple values supported)
- `keyword` - Search in title, description, company_name, emirate, district
- `offers_box_only` - Filter offers box ads only (true/false)
- `sort` - Sorting: `latest`, `most_viewed`, `rank` (default: latest)
- `per_page` - Results per page (default: 15)

### Examples

#### Job Category and Location
```
GET /api/jobs/search?category_type=IT,Engineering&emirate=Dubai,Abu Dhabi
```

#### Section Type Filter
```
GET /api/jobs/search?section_type=Full Time,Part Time&district=Downtown,Marina
```

#### Keyword Search
```
GET /api/jobs/search?keyword=developer&category_type=IT&emirate=Dubai
```

## 6. Electronics Ads

### Endpoints
- **GET** `/api/electronics/search` - Smart search with multiple filters
- **GET** `/api/electronics/offers-box/ads` - Get active offers box ads

### Search Parameters
- `section_type` - Electronics sections (multiple values supported)
- `brand` - Product brands (multiple values supported)
- `product_name` - Product name search
- `emirate` - Emirates (multiple values supported)
- `district` - Districts (multiple values supported)
- `warranty` - Warranty availability (true/false)
- `min_price` - Minimum price filter
- `max_price` - Maximum price filter
- `keyword` - Search in title, description, product_name, brand, section_type
- `in_offers_box` - Filter offers box ads only (true/false)
- `sort_by` - Sorting: `latest`, `most_viewed`, `rank`, `price_low`, `price_high` (default: latest)
- `per_page` - Results per page (default: 15)

### Examples

#### Brand and Section Search
```
GET /api/electronics/search?brand=Samsung,Apple&section_type=Smartphones,Tablets
```

#### Price Range with Warranty
```
GET /api/electronics/search?min_price=500&max_price=2000&warranty=true&emirate=Dubai
```

#### Comprehensive Electronics Search
```
GET /api/electronics/search?section_type=Laptops,Computers&brand=Dell,HP&keyword=gaming&sort_by=price_low
```

#### Offers Box Electronics
```
GET /api/electronics/offers-box/ads?limit=8
```

## Response Format

All search endpoints return paginated results in the following format:

```json
{
  "current_page": 1,
  "data": [
    {
      "id": 1,
      "title": "Ad Title",
      "description": "Ad Description",
      // ... other ad fields
    }
  ],
  "first_page_url": "http://example.com/api/search?page=1",
  "from": 1,
  "last_page": 5,
  "last_page_url": "http://example.com/api/search?page=5",
  "links": [...],
  "next_page_url": "http://example.com/api/search?page=2",
  "path": "http://example.com/api/search",
  "per_page": 15,
  "prev_page_url": null,
  "to": 15,
  "total": 67
}
```

## Offers Box Endpoints

All categories have dedicated offers box endpoints that return active promotional ads:

- `/api/restaurants/offers-box/ads?limit=10`
- `/api/real-estates/offers-box/ads?limit=10`
- `/api/car-services-ads/offers-box/ads?limit=10`
- `/api/car-rent-ads/offers-box/ads?limit=10`
- `/api/jobs/offers-box/ads?limit=10`

## Backward Compatibility

The existing endpoints continue to work with single-value filters. The new smart search endpoints are additive and don't break existing functionality.

### Legacy Parameters (Still Supported)
- `emirate_legacy` - Single emirate value
- `district_legacy` - Single district value
- `category_legacy` - Single category value
- etc.

## Error Handling

All endpoints return appropriate HTTP status codes:
- `200` - Success
- `400` - Bad Request (invalid parameters)
- `422` - Validation Error
- `500` - Server Error

## Rate Limiting

Standard API rate limiting applies to all search endpoints. Consider implementing caching for frequently accessed searches.

## Notes

1. **Multiple Values**: Can be passed as comma-separated strings or arrays
2. **Case Sensitivity**: Searches are case-insensitive
3. **Partial Matching**: Keyword searches use LIKE queries with wildcards
4. **Performance**: Indexes are recommended on frequently searched fields
5. **Validation**: All parameters are validated and sanitized
6. **Caching**: Consider implementing Redis caching for popular searches

## Testing Examples

### Using cURL

```bash
# Restaurant search with multiple categories
curl "http://your-domain.com/api/restaurants/search?category=Fast Food,Italian&emirate=Dubai"

# Real estate search with price range
curl "http://your-domain.com/api/real-estates/search?contract_type=Sale&price_range=500000-1000000"

# Car services with keyword search
curl "http://your-domain.com/api/car-services-ads/search?keyword=oil change&emirate=Dubai,Sharjah"

# Job search with multiple filters
curl "http://your-domain.com/api/jobs/search?category_type=IT&section_type=Full Time&keyword=developer"

# Electronics search with brand and warranty
curl "http://your-domain.com/api/electronics/search?brand=Samsung,Apple&warranty=true&emirate=Dubai"
```

### Using JavaScript/Axios

```javascript
// Multiple values as array
const response = await axios.get('/api/restaurants/search', {
  params: {
    emirate: ['Dubai', 'Abu Dhabi'],
    category: ['Fast Food', 'Italian'],
    sort: 'most_viewed'
  }
});

// Multiple values as comma-separated string
const response2 = await axios.get('/api/real-estates/search?emirate=Dubai,Sharjah&property_type=Apartment,Villa');

// Electronics search with multiple brands and sections
const response3 = await axios.get('/api/electronics/search', {
  params: {
    brand: ['Samsung', 'Apple', 'Sony'],
    section_type: ['Smartphones', 'Tablets'],
    warranty: true,
    sort_by: 'price_low'
  }
});
```

This smart search system provides powerful and flexible filtering capabilities while maintaining backward compatibility with existing implementations.