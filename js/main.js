  let currentSlide = 0;
      const slides = document.querySelectorAll(".slide");
      const dots = document.querySelectorAll(".dot");

      function showSlide(index) {
        if (index >= slides.length) {
          currentSlide = 0;
        } else if (index < 0) {
          currentSlide = slides.length - 1;
        } else {
          currentSlide = index;
        }

        const offset = (-currentSlide * 100) / slides.length;
        document.querySelector(
          ".slider"
        ).style.transform = `translateX(${offset}%)`;

        dots.forEach((dot) => dot.classList.remove("active"));
        dots[currentSlide].classList.add("active");
      }

      dots.forEach((dot, index) => {
        dot.addEventListener("click", () => showSlide(index));
      });

      setInterval(() => {
        showSlide(currentSlide + 1);
      }, 5000);

      document.querySelectorAll('.navbar-nav .nav-item').forEach((link, index, links) => {
      if (index < links.length - 2) {
        link.addEventListener('click', function() {
          links.forEach((item, i) => {
            if (i < links.length - 2) {
              item.classList.remove('active');
            }
          });

          this.classList.add('active');
        });
      }
     });

