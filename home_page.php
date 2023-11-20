<?php
@include 'config.php';
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Browse Events by Category</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Chakra+Petch:ital,wght@1,700&family=Stardos+Stencil&display=swap" rel="stylesheet">
    <style>
      * {
        font-family: "Poppins", sans-serif,"Brush Script MT";
        margin: 0;
        padding: 0;
        outline: none;
        border: none;
        text-decoration: none;
      }
      body {
        min-height: 100%;
      }
      .nav {
        min-height: 7vh;
        background: #7c4bf8;
        padding: 5px;
        padding-left: 10px;
        display: flex;
        align-items: center;
        justify-content: space-between;
      }
      .nav .logo{
        font-size: 2rem;
        text-transform: uppercase;
        font-weight: 600;
        color: #eee;
        font-family: "Stardos Stencil";
      }
      .nav .right-btn button,
      .nav .right-btn a {
        font-size: 1.5rem;
        font-family: inherit;
        background: #eee;
        padding: 5px;
        margin: 0 10px;
        border: 1px solid #000;
        border-radius: 5px;
      }
      .categories {
        margin: 0 auto;
        min-height: 82vh;
        background: #eee;
        display: flex;
        flex-flow: row wrap;
        justify-content: center;
        align-items: center;
      }

      .category {
        width: 220px;
        height: 200px;
        background-color: #fff;
        padding: 20px;
        margin: 20px;
        margin-right: 100px;
        margin-left: 100px;
        text-align: center;
        border: 1px solid #000;
        border-radius: 10px;
      }
      .category h3 {
        font-size: 24px;
        margin-bottom: 10px;
      }

      .category p {
        font-size: 16px;
      }

      .category img {
        width: 75%;
        height: 75%;
      }
      .footer {
        min-height: 8vh;
        background: #7c4bf8;
        padding: 5px;
        padding-left: 10px;
      }
    </style>
  </head>
  <body>
    <div class="nav">
      <div class="logo">Event Spot</div>
      <div class="right-btn">
        <a href="login_form.php">log in</a>
        <a href="all_home_events.php">All events</a>
      </div>
    </div>
    <div class="categories">
        <a href="music_events.php">
          <div class="category">
          <h3>Music Events</h3>
          <img src="https://www.seekpng.com/png/detail/284-2845426_of-band-names-today-on-music-band.png" />
          </div>
        </a>

        <a href="cultural_events.php">
          <div class="category">
          <h3>Cultural Events</h3>
          <img src="https://c1.klipartz.com/pngpicture/766/662/sticker-png-india-temple-bharatanatyam-natya-shastra-temple-dance-indian-classical-dance-dance-in-india-arangetram-kuchipudi.png" />
          </div>
        </a>

                <a href="political_events.php">
      <div class="category">
          <h3>Political Events</h3>
          <img src="https://get.pxhere.com/photo/public-speaking-ambassador-introduction-microphone-speech-ceo-audio-silhouette-center-communication-conference-equipment-interviewing-journalist-news-newscaster-performance-presentation-presenter-press-public-reporter-speaking-technology-political-gesture-audio-equipment-sleeve-font-podium-event-thumb-job-graphics-sitting-symbol-illustration-brand-stencil-logo-employment-Public-address-system-orator-line-art-Automotive-decal-clip-art-1637899.jpg" />
              </div>
        </a>

        <a href="education_events.php">
      <div class="category">
          <h3>Education Events</h3>
          <img src="https://img.lovepik.com/free-png/20210928/lovepik-black-and-white-graduation-student-silhouette-png-image_401736682_wh1200.png" />
             </div>
        </a>

                <a href="party_events.php">
      <div class="category">
          <h3>Party Events</h3>
          <img src="https://p1.hiclipart.com/preview/866/908/50/confetti-emoji-party-popper-party-horn-ball-sign-of-the-horns-text-blackandwhite-line-png-clipart.jpg" />
             </div>
        </a>

                <a href="sport_events.php">
      <div class="category">
          <h3>Sports Events</h3>
          <img src="https://e7.pngegg.com/pngimages/47/661/png-clipart-basketball-player-sport-silhouette-basketball-hand-sport.png" />
              </div>
        </a>
    </div>
    <div class="footer"></div>
  </body>
</html>
