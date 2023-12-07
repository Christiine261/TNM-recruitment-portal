<!--<a href="index.html" class="logo me-auto"><img src="assets/img/tnm-logo.png" alt="my image" class="img-fluid"></a>
-->
<link href="assets/css/style.css" rel="stylesheet">

<nav id="navbar" class="navbar order-last order-lg-0">
    <ul>
        
        <li <?php if ($currentPage === 'home') echo 'class="active"'; ?>><a href="index.php">Home</a></li>
        
        <li <?php if ($currentPage === 'jobs') echo 'class="active"'; ?>><a href="jobs.php">Jobs</a></li>
        <li <?php if ($currentPage === 'Interviews') echo 'class="active"'; ?>><a href="Interviews.php">Interviews</a></li>
        
        <li <?php if ($currentPage === 'about') echo 'class="active"'; ?>><a href="about.php">About</a></li>
        <li <?php if ($currentPage === 'contact') echo 'class="active"'; ?>><a href="contact.php">Contact</a></li>
    </ul>
    <i class="bi bi-list mobile-nav-toggle"></i>
    
</nav>