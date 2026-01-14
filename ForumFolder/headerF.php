<link rel="stylesheet" href="/ForumFolder/styleForum.css">
<header class="topbar header-div">
        <div class="header-left">
        <a href="/?nav=forum"><button>Peter's Forum</button></a>

        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="/?nav=logout">
                <button>Log Out (<?php echo e($_SESSION['username']); ?>)</button>
            </a>
        <?php endif; ?>
    </div>

    <div class="header-right">

        <?php if (isset($_SESSION['user_id'])): ?>
            <div class="profile-menu">
                <button class="profile-toggle" tabindex="0">Change Photo ▾</button>

                <div class="header-dropdown">
                    <form action="/?nav=upload_profile" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="csrf" value="<?php echo e(csrf_token()); ?>">

                        <input type="file" name="profile_pic" accept="image/*">

                        <button type="submit">Upload</button>
                    </form>
                </div>
            </div>
        <?php else: ?>
            <a href="/?nav=login"><button>Log In</button></a>
            <a href="/?nav=register"><button>Register</button></a>
        <?php endif; ?>

    </div>
</header>
