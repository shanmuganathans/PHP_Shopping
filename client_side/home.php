<?php
include 'db.php';

session_start();

// Redirect to login if user is not logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = htmlspecialchars($_SESSION['username']); // Prevent XSS
// Fetch user feedback
$feedback_query = "SELECT id, feedback FROM feedbacks WHERE username = ?";
$stmt = $conn->prepare($feedback_query);
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->bind_result($feedback_id, $user_feedback);
$stmt->fetch();
$stmt->close();

// Fetch latest feedbacks for display
$latest_feedbacks_query = "SELECT username, feedback FROM feedbacks ORDER BY id DESC LIMIT 5";
$latest_feedbacks = $conn->query($latest_feedbacks_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Our Bakery</title>
    <link rel="stylesheet" href="home.css">
</head>
<body>

    <!-- Navbar -->
    <div class="navbar">
        <a href="home.php">Home</a>
        <a href="menu.php">Menu</a>
        <a href="shop.php">Shop</a>
        <a href="my_orders.php">My Orders</a>
        <a href="about.php">About Us</a>
        <a href="contact.php">Contact Us</a>
        <a href="logout.php">Logout</a>
    </div>

    <!-- Hero Section -->
    <section class="hero">
        <h1>Welcome, <?= $username ?>!</h1>
        <p>Freshly baked treats, made with love!</p>
    </section>

    <!-- Why Choose Us -->
    <div class="content">
        <h2>Why Choose Us?</h2>
        <p>We offer a delightful variety of baked goods, crafted with the finest ingredients to bring joy to your taste buds. From cakes to cookies, everything is made fresh daily!</p>
        <a href="menu.php" class="cta-button">Explore Our Menu</a>
    </div>

    <!-- Featured Products -->
    <section class="featured-products">
        <h2>Featured Products</h2>
        <div class="product-list">
            <div class="product">
                <img src="../images/gulab_juman_cake.jpg" alt="Gulab Jamun Cake" width="276" height="285" loading="lazy">
                <h3>Gulab Jamun Cake</h3>
                <p>₹120 per slice</p>
                <a href="shop.php" class="btn">Shop Now</a>
            </div>
            <div class="product">
                <img src="../images/rava_kesari_cake.jpg" alt="Rava Kesari Cake" width="268" height="290" loading="lazy">
                <h3>Rava Kesari Cake</h3>
                <p>₹100 per slice</p>
                <a href="shop.php" class="btn">Shop Now</a>
            </div>
            <div class="product">
                <img src="../images/chocolate_cake.jpg" alt="Chocolate Cake" width="258" height="242" loading="lazy">
                <h3>Chocolate Cake</h3>
                <p>₹110 per slice</p>
                <a href="shop.php" class="btn">Shop Now</a>
            </div>
        </div>
    </section>

    <!-- About Us Teaser -->
    <section class="about-us">
        <h2>About Us</h2>
        <p>Opened during the challenging times of the COVID-19 pandemic, our bakery has become a haven for all things sweet! With a passion for baking since my early years, I decided to turn my dream into a reality. Every product here is made with love and care, using only the finest ingredients. <a href="about.php">Learn more about our story</a>.</p>
    </section>

    <!-- Testimonials Section with Conditional Pagination -->
    <section class="testimonials">
        <h2>What Our Customers Say</h2>
        <a href="review.php" class="feedback-btn">
            <?= ($user_feedback) ? "Edit Review" : "Write Review"; ?>
        </a>
        <div id="feedback-list">
            <?php
            // Pagination Logic
            $limit = 5; // Number of reviews per page
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $offset = ($page - 1) * $limit;

            // Get Total Feedback Count
            $total_feedbacks_query = "SELECT COUNT(*) AS total FROM feedbacks";
            $total_result = $conn->query($total_feedbacks_query);
            $total_feedbacks = $total_result->fetch_assoc()['total'];
            $total_pages = ceil($total_feedbacks / $limit);

            // Fetch Feedback for the Current Page
            $paginated_feedbacks_query = "SELECT username, feedback FROM feedbacks ORDER BY id DESC LIMIT $limit OFFSET $offset";
            $paginated_feedbacks = $conn->query($paginated_feedbacks_query);

            while ($row = $paginated_feedbacks->fetch_assoc()):
            ?>
                <div class="testimonial">
                    <p>"<?= htmlspecialchars($row['feedback']) ?>"</p>
                    <p>- <?= htmlspecialchars($row['username']) ?></p>
                </div>
            <?php endwhile; ?>
        </div>

        <!-- Show Pagination Controls Only If More Than One Page -->
        <?php if ($total_pages > 1): ?>
            <div class="pagination">
                <?php if ($page > 1): ?>
                    <a href="?page=<?= $page - 1 ?>">&laquo; Previous</a>
                <?php endif; ?>
                
                <span>Page <?= $page ?> of <?= $total_pages ?></span>

                <?php if ($page < $total_pages): ?>
                    <a href="?page=<?= $page + 1 ?>">Next &raquo;</a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </section>


    <!-- Customer Testimonials
    <section class="testimonials">
        <h2>What Our Customers Say</h2>
        <div class="testimonial-slider">
            <div class="testimonial">
                <p>"The best cake I've ever had! Soft, moist, and the perfect amount of sweetness."</p>
                <p>- Aditi</p>
            </div>
            <div class="testimonial">
                <p>"I love the variety of treats here. Every bite is a burst of flavor!"</p>
                <p>- Rajesh</p>
            </div>
            <div class="testimonial">
                <p>"Incredible pastries and top-notch service. Highly recommend this bakery!"</p>
                <p>- Priya</p>
            </div>
        </div>
    </section> -->

    <!-- Special Offers -->
    <section class="special-offers">
        <h2>Special Offers</h2>
        <p>Get a 10% discount on your first order! <a href="shop.php">Order Now</a></p>
    </section>

    <!-- Popular Categories -->
    <section class="popular-categories">
        <h2>Explore Our Menu</h2>
        <div class="category-list">
            <div class="category">
                <img src="images/cakes.jpg" alt="Cakes" loading="lazy">
                <h3>Cakes</h3>
                <a href="menu.php">View Menu</a>
            </div>
            <div class="category">
                <img src="images/sweets.jpg" alt="Sweets" loading="lazy">
                <h3>Sweets & Desserts</h3>
                <a href="menu.php">View Menu</a>
            </div>
            <div class="category">
                <img src="images/cookies.jpg" alt="Cookies & Biscuits" loading="lazy">
                <h3>Cookies & Biscuits</h3>
                <a href="menu.php">View Menu</a>
            </div>
        </div>
    </section>

    <!-- Order Now CTA -->
    <section class="order-now">
        <h2>Order Your Favorite Treats</h2>
        <a href="shop.php" class="btn">Order Now</a>
    </section>

    <!-- Newsletter Signup -->
    <section class="newsletter">
        <h2>Stay Updated!</h2>
        <form action="subscribe.php" method="POST">
            <input type="email" name="email" placeholder="Enter your email" required>
            <button type="submit" class="btn">Subscribe</button>
        </form>
    </section>

    <!-- Seasonal Specials -->
    <section class="seasonal-specials">
        <h2>Seasonal Specials</h2>
        <p>Check out our special holiday treats and themed cakes! Perfect for celebrations. <a href="shop.php">Browse our seasonal collection</a>.</p>
    </section>

    <!-- Footer -->
    <div class="footer">
        &copy; 2025 Our Bakery. All rights reserved.
    </div>
    <script>
    function openFeedbackModal() {
        document.getElementById('feedbackModal').style.display = 'block';
    }

    function closeFeedbackModal() {
        document.getElementById('feedbackModal').style.display = 'none';
    }

    function saveFeedback() {
        let feedbackText = document.getElementById('feedbackText').value;
        let feedbackId = document.getElementById('feedbackId').value;

        fetch('save_feedback.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `feedback_text=${encodeURIComponent(feedbackText)}&feedback_id=${feedbackId}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === "success") {
                updateFeedbackList(data.feedbacks);
                closeFeedbackModal();
            } else {
                alert("Error saving feedback.");
            }
        });
    }

    function deleteFeedback() {
        let feedbackId = document.getElementById('feedbackId').value;

        fetch('delete_feedback.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `feedback_id=${feedbackId}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === "success") {
                updateFeedbackList(data.feedbacks);
                closeFeedbackModal();
            } else {
                alert("Error deleting feedback.");
            }
        });
    }

    function updateFeedbackList(feedbacks) {
        let feedbackList = document.getElementById('feedback-list');
        feedbackList.innerHTML = '';
        feedbacks.forEach(feedback => {
            feedbackList.innerHTML += `<div class="testimonial"><p>"${feedback.feedback}"</p><p>- ${feedback.username}</p></div>`;
        });
    }
</script>


</body>
</html>
