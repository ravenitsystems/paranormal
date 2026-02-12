<script setup>
import bannerImg from '../assets/banner-castle.png';
</script>

<template>
    <div class="home">
        <div class="banner-wrap">
            <img
                :src="bannerImg"
                alt="Spooky castle at night"
                class="banner-img"
            />
            <div class="banner-overlay" aria-hidden="true" />
        </div>
        <div class="content">
            <h1>HOME PAGE</h1>
            <p>Test Home Page</p>
        </div>
    </div>
</template>

<style scoped>
.home {
    margin: -1.5rem -1rem 0;
}

@media (min-width: 768px) {
    .home {
        margin: -2rem -1.5rem 0;
    }
}

/* Full-bleed: banner spans full viewport width; content stays contained */
.banner-wrap {
    position: relative;
    width: 100vw;
    max-width: 100vw;
    margin-left: calc(50% - 50vw);
    overflow: hidden;
    border-bottom: 1px solid rgba(180, 83, 9, 0.25);
}

.banner-img {
    display: block;
    width: 100%;
    height: auto;
    max-height: 220px;
    object-fit: cover;
    object-position: center center;
}

.banner-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(
        to bottom,
        transparent 0%,
        rgba(13, 10, 15, 0.4) 70%,
        rgba(13, 10, 15, 0.85) 100%
    );
    pointer-events: none;
}

.content {
    padding-top: 1.5rem;
}
</style>
