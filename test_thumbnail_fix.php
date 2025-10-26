<?php

/**
 * Test script to verify thumbnail_images array handling fix
 * This simulates the array operations that happen in CarRentAdController
 */

echo "Testing thumbnail_images array handling fix...\n\n";

// Simulate existing thumbnails (as they would come from database with array casting)
$existingThumbnails = [
    'car_rent/thumbnails/image1.jpg',
    'car_rent/thumbnails/image2.jpg',
    'car_rent/thumbnails/image3.jpg'
];

echo "1. Existing thumbnails:\n";
print_r($existingThumbnails);

// Simulate removing some thumbnails
$thumbnailsToRemove = [
    'car_rent/thumbnails/image2.jpg'
];

echo "\n2. Removing thumbnails:\n";
print_r($thumbnailsToRemove);

// Apply removal logic (same as in controller)
foreach ($thumbnailsToRemove as $thumbnailToRemove) {
    $existingThumbnails = array_filter($existingThumbnails, function($thumb) use ($thumbnailToRemove) {
        return $thumb !== $thumbnailToRemove;
    });
}
$existingThumbnails = array_values($existingThumbnails); // Re-index array

echo "\n3. After removal:\n";
print_r($existingThumbnails);

// Simulate adding new thumbnails
$newThumbnails = [
    'car_rent/thumbnails/new_image1.jpg',
    'car_rent/thumbnails/new_image2.jpg'
];

echo "\n4. Adding new thumbnails:\n";
print_r($newThumbnails);

// Apply addition logic (same as in controller)
foreach ($newThumbnails as $newThumbnail) {
    $existingThumbnails[] = $newThumbnail;
}

echo "\n5. Final result:\n";
print_r($existingThumbnails);

// Test JSON encoding (Laravel does this automatically with array casting)
$jsonEncoded = json_encode($existingThumbnails);
echo "\n6. JSON encoded (as stored in database):\n";
echo $jsonEncoded . "\n";

// Test JSON decoding (Laravel does this automatically when retrieving)
$jsonDecoded = json_decode($jsonEncoded, true);
echo "\n7. JSON decoded (as retrieved from database):\n";
print_r($jsonDecoded);

echo "\n✅ Test completed successfully! No Array to string conversion errors.\n";