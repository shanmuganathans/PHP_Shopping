<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu</title>
    <link rel="stylesheet" href="menu.css">
</head>
<body>
<div class="navbar">
    <a href="home.php">Home</a>
    <a href="menu.php">Menu</a>
    <a href="shop.php">Shop</a>
    <a href="about.php">About Us</a>
    <a href="contact.php">Contact Us</a>
	<a href="logout.php">Logout</a></div>
  <header>
        <h1>Our Bakery Menu</h1>
    </header>

    <div class="search-container">
        <input type="text" id="search" placeholder="Search items...">
        <button onClick="filterMenu()" id="searchBtn">Search</button>
    </div>

    <div class="menu-container">
        <div class="menu-category" id="cakes">
            <h2>Cakes</h2>
            <div class="menu-item" data-name="Gulab Jamun Cake">
                <img src="../images/gulab juman cake.jpg" alt="Gulab Jamun Cake" width="750" height="720">
                <h3>Gulab Jamun Cake - ₹120 per slice</h3>
          </div>
            <div class="menu-item" data-name="Rava Kesari Cake">
                <img src="../images/rava kesari cake.jpg" alt="Rava Kesari Cake" width="1200" height="1200">
                <h3>Rava Kesari Cake - ₹100 per slice</h3>
          </div>
            <div class="menu-item" data-name="Milk Cake">
                <img src="../images/milk cake.jpg" alt="Milk Cake" width="2940" height="1960">
                <h3>Milk Cake - ₹150 per slice</h3>
          </div>
            <div class="menu-item" data-name="Mango Cake">
                <img src="../images/mango cake.jpg" alt="Mango Cake" width="626" height="417">
                <h3>Mango Cake - ₹130 per slice</h3>
          </div>
            <div class="menu-item" data-name="Chocolate Cake">
                <img src="../images/chocolate cake.jpg" alt="Chocolate Cake" width="1096" height="1095">
                <h3>Chocolate Cake - ₹110 per slice</h3>
          </div>
        </div>

        <div class="menu-category" id="sweets">
            <h2>Sweets & Desserts</h2>
            <div class="menu-item" data-name="Gulab Jamun">
              <img src="../images/gulab jamun.jpg" alt="Gulab Jamun" width="456" height="499">
              <h3>Gulab Jamun - ₹40 per piece</h3>
          </div>
            <div class="menu-item" data-name="Jalebi">
                <img src="../images/jalebi.jpg" alt="Jalebi" width="1513" height="1087">
                <h3>Jalebi - ₹50 per serving</h3>
          </div>
            <div class="menu-item" data-name="Barfi">
                <img src="../images/barfi.jpg" alt="Barfi" width="505" height="507">
                <h3>Barfi (Pistachio, Coconut, Rose) - ₹60 per piece</h3>
          </div>
            <div class="menu-item" data-name="Rasgulla">
                <img src="../images/rasgulla.jpg" alt="Rasgulla" width="1089" height="1098">
                <h3>Rasgulla - ₹30 per piece</h3>
          </div>
            <div class="menu-item" data-name="Kaju Katli">
                <img src="../images/kaju katli.jpg" alt="Kaju Katli" width="1389" height="1065">
                <h3>Kaju Katli - ₹80 per piece</h3>
          </div>
        </div>

        <div class="menu-category" id="cookies">
            <h2>Cookies & Biscuits</h2>
            <div class="menu-item" data-name="Chocolate Chip Cookies">
              <img src="../images/chocolate chip cookies.jpeg" alt="Chocolate Chip Cookies" width="275" height="183">
              <h3>Chocolate Chip Cookies - ₹25 per piece</h3>
          </div>
            <div class="menu-item" data-name="Coconut Cookies">
                <img src="../images/coconut cookies.jpg" alt="Coconut Cookies" width="1451" height="1036">
                <h3>Coconut Cookies - ₹20 per piece</h3>
          </div>
            <div class="menu-item" data-name="Butter Biscuits">
                <img src="../images/butter biscuits.jpg" alt="Butter Biscuits" width="2560" height="1706">
                <h3>Butter Biscuits - ₹20 per piece</h3>
          </div>
            <div class="menu-item" data-name="Peanut Butter Cookies">
              <img src="../images/peanut butter cookies.jpg" alt="Peanut Butter Cookies" width="800" height="800">
              <h3>Peanut Butter Cookies - ₹30 per piece</h3>
          </div>
            <div class="menu-item" data-name="Oatmeal Raisin Cookies">
                <img src="../images/oatmeal raisin cookie.jpg" alt="Oatmeal Raisin Cookies" width="612" height="459">
                <h3>Oatmeal Raisin Cookies - ₹20 per piece</h3>
          </div>
        </div>
    </div>

    <footer>
        <p>&copy; 2025 Our Bakery. All Rights Reserved.</p>
    </footer>

    <script>
        // JavaScript for searching the menu
        function filterMenu() {
            let input = document.getElementById("search").value.toLowerCase();
            let menuItems = document.getElementsByClassName("menu-item");

            for (let i = 0; i < menuItems.length; i++) {
                let itemName = menuItems[i].getAttribute("data-name").toLowerCase();
                if (itemName.includes(input)) {
                    menuItems[i].style.display = "block";
                } else {
                    menuItems[i].style.display = "none";
                }
            }
        }
    </script>

</body>
</html>