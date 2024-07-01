<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="contact.css">
    <!-- Fontawesome icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />
  </head>
  <body>

    
    <section class = "contact-section">
      <div class = "contact-bg">
        <h3>Get in Touch with Us</h3>
        <h2>contact us</h2>
        <div class = "line">
          <div></div>
          <div></div>
          <div></div>
        </div>
        <p class = "text">The website itself is a very successful learning website.</p>
      </div>


      <div class = "contact-body">

        <div class = "contact-form">
          <form action="contact.php" autocomplete="off" method="post">
            <div>
                <input type="text" class="form-control" name="first_name" placeholder="First Name">
                <input type="text" class="form-control" name="last_name" placeholder="Last Name">
            </div>
            <div>
                <input type="email" class="form-control" name="email" placeholder="E-mail">
                <input type="text" class="form-control" name="phone" placeholder="Phone">
            </div>
            <textarea rows="5" name="message" placeholder="Message" class="form-control"></textarea>
            <input type="submit" class="send-btn" value="Send Message">
        </form>
          <div>
            <img src = "inassets/img/image.png" alt = "">
          </div>
          

        </div>
      </div>
      <div class = "contact-info">
        <div>
          <span><i class = "fas fa-mobile-alt"></i></span>
          <span>Phone No.</span>
          <span class = "text">9820447233</span>
        </div>
        <div>
          <span><i class = "fas fa-envelope-open"></i></span>
          <span>E-mail</span>
          <span class = "text">shmail@company.com</span>
        </div>
        <div>
          <span><i class = "fas fa-map-marker-alt"></i></span>
          <span>Address</span>
          <span class = "text">Kandivali West , Mumbai -400067</span>
        </div>
      </div>
      </div>
    </section>

    

  </body>
</html>

