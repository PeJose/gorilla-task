<?php

declare(strict_types=1);

namespace Tests\Entity;

use App\Entity\Review;
use App\Enum\ReviewStatus;
use PHPUnit\Framework\TestCase;

class ReviewTest extends TestCase
{
  public function testReviewInitialization(): void
  {
    $review = new Review(
      description: 'Test review',
      dateOfReview: new \DateTimeImmutable('2025-05-12'),
      weekInYear: '20',
      status: ReviewStatus::New,
      followingInstructions: 'Yes',
      contactEmail: 'test@example.com'
    );

    $this->assertEquals('Test review', $review->description);
    $this->assertEquals('2025-05-12', $review->dateOfReview->format('Y-m-d'));
    $this->assertEquals('20', $review->weekInYear);
    $this->assertEquals(ReviewStatus::New, $review->status);
    $this->assertEquals('Yes', $review->followingInstructions);
    $this->assertEquals('test@example.com', $review->contactEmail);
  }
}
