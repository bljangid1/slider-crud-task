<?php
include 'admin/config.php';

$categories = ['Learning','Technology','Communication'];
$sections = [];

foreach($categories as $cat){
    $stmt = $conn->prepare("SELECT * FROM sections WHERE category=? ORDER BY created_at ASC");
    $stmt->execute([$cat]);
    $sections[$cat] = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Wpoet Slider</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
<link rel="stylesheet" href="includes/css/style.css">
<style>

</style>
</head>

<body>

<section class="action-section">

<div class="container">

    <h2 class="section-title text-center">
        DelphianLogic in Action
    </h2>

    <p class="section-desc text-center">
        Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo
    </p>

    <!-- =====================================================
    DESKTOP VIEW
    ====================================================== -->

    <div class="desktop-view d-none d-lg-flex row g-0">

        <!-- LEFT TABS -->

        <div class="left-tabs col-xl-3 col-lg-4 p-4 d-flex flex-column justify-content-center">

            <?php $first = true; ?>

            <?php foreach($sections as $category => $items): ?>

            <div class="custom-tab <?= $first ? 'active' : '' ?>
                        shadow-sm p-3 px-4 mb-4 d-flex align-items-center justify-content-between"
                 data-category="<?= $category ?>">

                <div class="d-flex align-items-center gap-3">

                    <img src="assets/images/Dl-<?= strtolower($category) ?>.svg" width="40" height="45" style="object-fit:contain;">
                    <div class="tab-title">
                        <?= $category ?>
                    </div>

                </div>

                <div class="icon-indicator d-none align-items-center justify-content-center">
                    <?= $first ? '−' : '+' ?>
                </div>

            </div>

            <?php $first = false; ?>

            <?php endforeach; ?>

        </div>

        <!-- CENTER SLIDER -->

        <div class="center-slider col-xl-5 col-lg-4 position-relative overflow-hidden">

            <div class="swiper desktopSwiper h-100">

                <div class="swiper-wrapper">

                    <?php foreach($sections as $category => $items): ?>

                        <?php foreach($items as $item): ?>

                        <div class="swiper-slide"
                             data-category="<?= $category ?>">

                            <div class="slide d-flex flex-column justify-content-center align-items-center text-center p-5">

                                <div class="slide-tag mb-4">
                                    <?= $item['tag'] ?>
                                </div>

                                <div class="slide-title mb-4">
                                    <?= $item['title'] ?>
                                </div>

                                <a href="#" class="learn-btn">
                                    Learn More →
                                </a>

                            </div>

                        </div>

                        <?php endforeach; ?>

                    <?php endforeach; ?>

                </div>

                
                <div class="swiper-pagination"></div>

            </div>

        </div>

        <!-- RIGHT IMAGE -->

        <div class="right-image col-xl-4 col-lg-4">

            <div class="swiper imageSwiper h-100">

                <div class="swiper-wrapper">

                    <?php foreach($sections as $category => $items): ?>

                        <?php foreach($items as $item): ?>

                        <div class="swiper-slide"
                             data-category="<?= $category ?>">

                            <img src="admin/images/<?= $item['image'] ?>">

                        </div>

                        <?php endforeach; ?>

                    <?php endforeach; ?>

                </div>

            </div>

        </div>

    </div>

    <!-- =====================================================
    MOBILE VIEW
    ====================================================== -->

    <div class="mobile-view d-block d-lg-none "  id="mobileAccordion">

        <?php
        $mobileFirst = true;

        foreach($sections as $category => $items):
        ?>

        <div class="mobile-card mb-3">

            <button
                class="mobile-tab border-0 w-100 p-2 d-flex align-items-center justify-content-between" data-bs-toggle="collapse" data-bs-target="#mobile-<?= strtolower($category) ?>">
                <div class="d-flex align-items-center gap-3">

                    <img src="assets/images/Dl-<?= strtolower($category) ?>.svg" width="42">
                    <div class="mobile-tab-title">
                        <?= $category ?>
                    </div>
                </div>

                <div class="mobile-icon d-flex align-items-center justify-content-center">
                    <?= $mobileFirst ? '−' : '+' ?>
                </div>

            </button>

          <div class="collapse <?= $mobileFirst ? 'show' : '' ?> mobile-content mt-3" id="mobile-<?= strtolower($category) ?>" data-bs-parent="#mobileAccordion">

                <div class="swiper mobileSwiper">

                    <div class="swiper-wrapper">

                        <?php foreach($items as $item): ?>

                        <div class="swiper-slide">

                            <div class="mobile-slide-bg"
                                 style="background-image:url('admin/images/<?= $item['image'] ?>');">

                                <div class="mobile-overlay d-flex flex-column justify-content-center align-items-center text-center p-4">

                                    <div class="mobile-tag mb-4">
                                        <?= $item['tag'] ?>
                                    </div>

                                    <div class="mobile-slide-title mb-4">
                                        <?= $item['title'] ?>
                                    </div>

                                    <a href="#" class="mobile-learn">
                                        Learn More →
                                    </a>

                                </div>

                            </div>

                        </div>

                        <?php endforeach; ?>

                    </div>

                    <div class="swiper-pagination"></div>

                </div>

            </div>

        </div>

        <?php
        $mobileFirst = false;
        endforeach;
        ?>

    </div>

</div>

</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script src="includes/js/script.js"></script>


</body>
</html>