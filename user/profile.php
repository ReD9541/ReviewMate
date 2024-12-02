<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header("Location: /auth/page/login.php");
    exit();
}

include "../includes/db_connect.php";
include "../includes/header.php";
?>

<main data-page="profile" class="main-content">
    <div class="container">
        

        <div class="row">
            <div class="col-md-4">
                <div class="panel">
                    <div class="panel-heading">
                        <span class="panel-icon"><i class="fa fa-pencil"></i></span>
                        <span class="panel-title">About Me</span>
                    </div>
                    <div id="profile-section" class="page-heading mb-4">
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="tab-block">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#watched" data-toggle="tab">Movies Watched</a></li>
                        <li><a href="#reviewed" data-toggle="tab">Movies Reviewed</a></li>
                        <li><a href="#watchlist" data-toggle="tab">Watchlist</a></li>
                    </ul>
                    <div class="tab-content p30">
                        <div id="watched" class="tab-pane active">
                            <div class="row g-4" id="watched-movies">
                            </div>
                        </div>
                        <div id="reviewed" class="tab-pane">
                            <div class="row g-4" id="reviewed-movies">
                            </div>
                        </div>
                        <div id="watchlist" class="tab-pane">
                            <div class="row g-4" id="watchlist-movies">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include "../includes/footer.php"; ?>

<script src="/assets/scripts/scripts.js"></script>
<script>
    $(document).ready(function () {
        loadUserProfile();
    });
</script>
