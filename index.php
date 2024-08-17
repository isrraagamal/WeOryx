<?php
require("configuration.php"); 

try {
    $stmt = $pdo->prepare("SELECT * FROM service LIMIT 3");
    $stmt->execute();
    $services = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error fetching services: " . $e->getMessage();
}

try {
    $stmt = $pdo->prepare("SELECT * FROM team LIMIT 4");
    $stmt->execute();
    $teamMembers = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error fetching team members: " . $e->getMessage();
}

function truncateText($text, $length = 150) {
    $text = strip_tags($text);
    if (strlen($text) > $length) {
        $text = substr($text, 0, $length) . '...'; 
    }
    return $text;
}
?>



<?php require("header.php"); ?>
    <main>
      <section id="home">
        <div class="row">
          <div class="slider-container">
            <div class="slider">
              <div class="slide">
                <img src="./assets/images/banner.png" alt="Image 1" />
                <div class="caption">
                  <h1 class="text-uppercase">
                    Lorem Ipsum Neque<br />
                    porro qui dolorem
                  </h1>
                  <p>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed
                    do eiusmod<br />
                    tempor incididunt ut labore et dolore magna aliqua. Ut enim
                    ad minim<br />
                    veniam, quis nostrud exercitation
                  </p>
                  <button>Book Now</button>
                </div>
              </div>
              <div class="slide">
                <img src="./assets/images/banner.png" alt="Image 2" />
                <div class="caption">
                  <h1 class="text-uppercase">
                    Lorem Ipsum Neque<br />
                    porro qui dolorem
                  </h1>
                  <p>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed
                    do eiusmod<br />
                    tempor incididunt ut labore et dolore magna aliqua. Ut enim
                    ad minim<br />
                    veniam, quis nostrud exercitation
                  </p>
                  <button>Book Now</button>
                </div>
              </div>
              <div class="slide">
                <img src="./assets/images/banner.png" alt="Image 3" />
                <div class="caption">
                  <h1 class="text-uppercase">
                    Lorem Ipsum Neque<br />
                    porro qui dolorem
                  </h1>
                  <p>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed
                    do eiusmod<br />
                    tempor incididunt ut labore et dolore magna aliqua. Ut enim
                    ad minim<br />
                    veniam, quis nostrud exercitation
                  </p>
                  <button>Book Now</button>
                </div>
              </div>
              <div class="slide">
                <img src="./assets/images/banner.png" alt="Image 4" />
                <div class="caption">
                  <h1 class="text-uppercase">
                    Lorem Ipsum Neque<br />
                    porro qui dolorem
                  </h1>
                  <p>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed
                    do eiusmod<br />
                    tempor incididunt ut labore et dolore magna aliqua. Ut enim
                    ad minim<br />
                    veniam, quis nostrud exercitation
                  </p>
                  <button>Book Now</button>
                </div>
              </div>
              <div class="slide">
                <img src="./assets/images/banner.png" alt="Image 5" />
                <div class="caption">
                  <h1 class="text-uppercase">
                    Lorem Ipsum Neque<br />
                    porro qui dolorem
                  </h1>
                  <p>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed
                    do eiusmod<br />
                    tempor incididunt ut labore et dolore magna aliqua. Ut enim
                    ad minim<br />
                    veniam, quis nostrud exercitation
                  </p>
                  <button>Book Now</button>
                </div>
              </div>
            </div>
            <div class="dots">
              <span class="dot active"></span>
              <span class="dot"></span>
              <span class="dot"></span>
              <span class="dot"></span>
              <span class="dot"></span>
            </div>
          </div>
        </div>
      </section>
      <section id="about-us" class="my-5">
        <div class="row">
          <div class="container d-flex">
            <div class="col-6">
              <img src="./assets/images/about.png" alt="" />
            </div>
            <div class="col-6 pt-5">
              <h2>About Us</h2>
              <p class="pt-3 text-muted">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
                eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut
                enim ad minim veniam, quis nostrud exercitation Lorem ipsum
                dolor sit amet, consectetur adipiscing elit, sed do eiusmod
                tempor incididunt ut labore et dolore magna aliqua. Ut enim ad
                minim veniam, quis nostrud exercitation Lorem ipsum dolor sit
                amet, consectetur adipiscing elit, sed do eiusmod tempor
                incididunt ut labore et dolore magna aliqua. Ut enim ad minim
                veniam, quis nostrud exercitation
              </p>
            </div>
          </div>
        </div>
      </section>


    <section id="our-services">
    <div class="row text-center justify-content-center">
        <div class="line"></div>
        <h2 class="py-4 mx-3">Our Services</h2>
        <div class="line"></div>
    </div>
    <div class="container d-flex justify-content-center align-items-center">
        <div class="row w-100">
            <?php
            if (!empty($services)) {
                foreach ($services as $service) {
                    echo '<div class="col-md-4 mb-4">';
                    echo '<a href="./services-details.php?service_id=' . htmlspecialchars($service['service_id']) . '">';
                    echo '<div class="card text-center p-3 h-100">';
                    echo '<div class="circle-bg mx-auto mb-3">'; 
                    echo '<img src="' . htmlspecialchars($service['service_icon']) . '" alt="' . htmlspecialchars($service['service_name']) . '" class="circle-img" />';
                    echo '</div>';
                    echo '<h3>' . htmlspecialchars($service['service_name']) . '</h3>'; 
                    echo '<p class="text-muted">' . htmlspecialchars(truncateText($service['service_description'])) . '</p>'; 
                    echo '</div>';
                    echo '</a>';
                    echo '</div>';
                }
            } else {
                echo '<div class="col-12 text-center">';
                echo '<p>No services available at the moment. Please check back later.</p>';
                echo '</div>';
            }
            ?>
        </div>
      </div>
    </section>

    <section id="our-team">
    <div class="row justify-content-center">
        <div class="line"></div>
        <h2 class="py-4 mx-3">Our Team</h2>
        <div class="line"></div>
    </div>
    <div class="row">
        <div class="container d-flex m-auto">
            <?php
            if (!empty($teamMembers)) {
                foreach ($teamMembers as $member) {
                    echo '<div class="col-md-3 col-sm-6">';
                    echo '<a href="./team.php">';
                    echo '<img src="' . htmlspecialchars($member['employee_image']) . '" alt="' . htmlspecialchars($member['employee_name']) . '" />';
                    echo '<div>';
                    echo '<h3 style="color:#000!important;">'. htmlspecialchars($member['employee_title']). '. '. htmlspecialchars($member['employee_name']) . '</h3>';
                    echo '<h5>' . htmlspecialchars($member['employee_position']) . '</h5>';
                    echo '</div>';
                    echo '</a>';
                    echo '</div>';
                }
            } else {
                echo '<div class="col-12 text-center">';
                echo '<p>No team members available</p>';
                echo '</div>';
            }
            ?>
        </div>
    </div>
</section>


      <section id="resources">
        <div class="row text-center justify-content-center d-flex">
          <div class="line"></div>
          <h2 class="py-4 mx-3">Resources</h2>
          <div class="line"></div>
        </div>
        <div class="row">
          <div class="container">
            <div class="card-deck">
              <div class="card">
                <img
                  class="card-img-top"
                  src="./assets/images/resource.png"
                  alt="Card image cap"
                />
                <div class="card-body">
                  <h5 class="card-title font-weight-bold">Headline</h5>
                  <p class="card-text">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed
                    do eiusmod tempor incididunt ut labore et dolore magna
                    aliqua.
                  </p>
                </div>
              </div>
              <div class="card">
                <img
                  class="card-img-top"
                  src="./assets/images/resource.png"
                  alt="Card image cap"
                />
                <div class="card-body">
                  <h5 class="card-title font-weight-bold">Headline</h5>
                  <p class="card-text">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed
                    do eiusmod tempor incididunt ut labore et dolore magna
                    aliqua.
                  </p>
                </div>
              </div>
              <div class="card">
                <img
                  class="card-img-top"
                  src="./assets/images/resource.png"
                  alt="Card image cap"
                />
                <div class="card-body">
                  <h5 class="card-title font-weight-bold">Headline</h5>
                  <p class="card-text">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed
                    do eiusmod tempor incididunt ut labore et dolore magna
                    aliqua.
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="container justify-content-center text-center py-3">
            <div class="div-buttons">
              <button class="btn-prev">&lt;</button>
              <button>See More</button>
              <button class="btn-next">&gt;</button>
            </div>
          </div>
        </div>
      </section>
      <section id="our-testimonial">
        <div class="row justify-content-center text-center mt-5">
          <div class="line"></div>
          <h2 class="py-4 mx-3">Our Testimonial</h2>
          <div class="line"></div>
        </div>
        <div class="row">
          <div class="container justify-content-center text-center">
            <img src="./assets/images/elipse.png" alt="">
            <p>Israa Gamal</p>
            <div class="p-div">
              <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation</p>
            </div>
            </div>
          </div>
        </div>
      </section>
    </main>
    <?php require("footer.php"); ?>