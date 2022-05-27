<nav class="navbar navbar-expand-lg navbar-light">
    <ul class="navbar-nav">
      <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle user" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Sama
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="../index.php">Visit Shop</a>
          <a class="dropdown-item" href="members.php?do=Edit&userid=<?php echo $_SESSION['ID'] ?>">Edit Profile</a>
            <a class="dropdown-item" href="#">settings</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">logout</a>
          </div>
        </li>
    </ul>  
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item ">
        <a class="nav-link" href="Dashbord.php"><?php echo lang('home')?></a>
      </li>
      <li class="nav-item ">
        <a class="nav-link" href="items.php"><?php echo lang('items')?></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="categories.php"><?php echo lang('categories')?></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="members.php"><?php echo lang('members')?></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="comments.php"><?php echo lang('comments')?></a>
      </li>
      
     </ul>
    <!-- <ul class="navbar-nav">
    <li class="nav-item dropdown user">
        <a class="nav-link dropdown-toggle user" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Sama
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="members.php?do=Edit&userid=<?php echo $_SESSION['ID'] ?>">Edit Profile</a>
          <a class="dropdown-item" href="#">settings</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="logout.php">logout</a>
        </div>
      </li>
</ul> -->
  </div>
</nav>