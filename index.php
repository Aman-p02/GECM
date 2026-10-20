<?php
$page_title = "Government Engineering College, Modasa";
$active_page = "home";
$extra_css = "css/home.css";
$extra_js = "js/home.js";
include_once __DIR__ . '/includes/header.php';
?>

<!-- Hero Section with Background Carousel -->
<section id="about" class="hero govt-hero" aria-label="Campus Showcase">
    <!-- Hero Image Carousel Slides -->
    <div class="hero-slider" id="heroSlider">
        <div class="hero-slide active" style="background-image: url('images/hero_campus_1.webp');"
            data-label="Main Campus & Admin Block"></div>
        <div class="hero-slide" style="background-image: url('images/hero_campus_2.jpg');"
            data-label="Engineering Academic Complex"></div>
        <div class="hero-slide" style="background-image: url('images/hero_campus_3.jpg');"
            data-label="Central Library & Auditorium"></div>
        <div class="hero-slide" style="background-image: url('images/hero_campus_4.jpg');"
            data-label="Lush Green Campus Aerial View"></div>
    </div>

    <div class="hero-overlay"></div>

    <div class="hero-content">
        <h1 class="hero-title fade-in-up delay-1">Welcome to <br> Government Engineering College, Modasa</h1>
        <p class="hero-subtitle fade-in-up delay-2">Affiliated to Gujarat Technological University (GTU) &bull;
            Approved by AICTE, New Delhi</p>

        <div class="hero-buttons fade-in-up delay-3">
            <a href="#" class="btn btn-primary"><i class="fas fa-street-view"></i> Virtual Tour</a>
        </div>
    </div>

    <!-- Carousel Navigation Arrows -->
    <button class="hero-nav hero-prev" id="heroPrevBtn" aria-label="Previous Slide">
        <i class="fas fa-chevron-left"></i>
    </button>
    <button class="hero-nav hero-next" id="heroNextBtn" aria-label="Next Slide">
        <i class="fas fa-chevron-right"></i>
    </button>

    <!-- Carousel Indicators (Dots) -->
    <div class="hero-indicators" id="heroIndicators">
        <button class="hero-dot active" data-index="0" aria-label="Slide 1"></button>
        <button class="hero-dot" data-index="1" aria-label="Slide 2"></button>
        <button class="hero-dot" data-index="2" aria-label="Slide 3"></button>
        <button class="hero-dot" data-index="3" aria-label="Slide 4"></button>
    </div>
</section>

<!-- Notice Board Marquee -->
<div class="news-ticker-container">
    <div class="ticker-title">Updates</div>
    <div class="ticker-content">
        <marquee behavior="scroll" direction="left" onmouseover="this.stop();" onmouseout="this.start();">
            <span><i class="fas fa-bell"></i> Admission open for BE First Year 2024-25.</span>
            <span><i class="fas fa-bell"></i> Mid-Semester Exams schedule has been released. Check notice board for
                details.</span>
            <span><i class="fas fa-bell"></i> State Level Hackathon 2024 registrations are now open!</span>
        </marquee>
    </div>
</div>

<!-- Main Content Grid for Notices and Quick Links -->
<section id="events" class="section container two-col-layout">
    <div class="notice-board">
        <div class="section-header">
            <h4>Notice Board</h4>
            <a href="#" class="view-all">View All</a>
        </div>
        <div class="notice-scroll-container">
            <div class="notice-marquee">
                <ul class="notice-list">
                    <li>
                        <div class="date"><span class="day">15</span><span class="month">Oct</span></div>
                        <div class="notice-text">
                            <a href="#">Guidelines for AICTE Pragati & Saksham Scholarship Schemes 2024-25</a>
                            <span class="badge new">New</span>
                        </div>
                    </li>
                    <li>
                        <div class="date"><span class="day">10</span><span class="month">Oct</span></div>
                        <div class="notice-text">
                            <a href="#">Timetable for B.E. Semester 5 Mid-Semester Examination</a>
                        </div>
                    </li>
                    <li>
                        <div class="date"><span class="day">02</span><span class="month">Oct</span></div>
                        <div class="notice-text">
                            <a href="#">Result Declaration: BE Sem-6 Regular Summer 2024</a>
                        </div>
                    </li>
                    <li>
                        <div class="date"><span class="day">28</span><span class="month">Sep</span></div>
                        <div class="notice-text">
                            <a href="#">Academic Calendar for Odd Semester 2024-25</a>
                        </div>
                    </li>
                    <li>
                        <div class="date"><span class="day">20</span><span class="month">Sep</span></div>
                        <div class="notice-text">
                            <a href="#">Submission of Scholarship Forms for SC/ST Students</a>
                            <span class="badge new">Urgent</span>
                        </div>
                    </li>
                    <li>
                        <div class="date"><span class="day">15</span><span class="month">Sep</span></div>
                        <div class="notice-text">
                            <a href="#">Hostel Admission Merit List Announced for First Year Students</a>
                        </div>
                    </li>
                    <li>
                        <div class="date"><span class="day">10</span><span class="month">Sep</span></div>
                        <div class="notice-text">
                            <a href="#">GTU TechFest 2024 Participation Registration Open</a>
                        </div>
                    </li>
                    <li>
                        <div class="date"><span class="day">05</span><span class="month">Sep</span></div>
                        <div class="notice-text">
                            <a href="#">Revised Syllabus for Engineering Mechanics (Civil Dept)</a>
                        </div>
                    </li>
                </ul>
                <!-- Duplicated list for seamless looping -->
                <ul class="notice-list" aria-hidden="true">
                    <li>
                        <div class="date"><span class="day">15</span><span class="month">Oct</span></div>
                        <div class="notice-text">
                            <a href="#">Guidelines for AICTE Pragati & Saksham Scholarship Schemes 2024-25</a>
                            <span class="badge new">New</span>
                        </div>
                    </li>
                    <li>
                        <div class="date"><span class="day">10</span><span class="month">Oct</span></div>
                        <div class="notice-text">
                            <a href="#">Timetable for B.E. Semester 5 Mid-Semester Examination</a>
                        </div>
                    </li>
                    <li>
                        <div class="date"><span class="day">02</span><span class="month">Oct</span></div>
                        <div class="notice-text">
                            <a href="#">Result Declaration: BE Sem-6 Regular Summer 2024</a>
                        </div>
                    </li>
                    <li>
                        <div class="date"><span class="day">28</span><span class="month">Sep</span></div>
                        <div class="notice-text">
                            <a href="#">Academic Calendar for Odd Semester 2024-25</a>
                        </div>
                    </li>
                    <li>
                        <div class="date"><span class="day">20</span><span class="month">Sep</span></div>
                        <div class="notice-text">
                            <a href="#">Submission of Scholarship Forms for SC/ST Students</a>
                            <span class="badge new">Urgent</span>
                        </div>
                    </li>
                    <li>
                        <div class="date"><span class="day">15</span><span class="month">Sep</span></div>
                        <div class="notice-text">
                            <a href="#">Hostel Admission Merit List Announced for First Year Students</a>
                        </div>
                    </li>
                    <li>
                        <div class="date"><span class="day">10</span><span class="month">Sep</span></div>
                        <div class="notice-text">
                            <a href="#">GTU TechFest 2024 Participation Registration Open</a>
                        </div>
                    </li>
                    <li>
                        <div class="date"><span class="day">05</span><span class="month">Sep</span></div>
                        <div class="notice-text">
                            <a href="#">Revised Syllabus for Engineering Mechanics (Civil Dept)</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="recent-events-card">
        <div class="section-header">
            <h4>Recent Events</h4>
            <a href="#" class="view-all">All Events</a>
        </div>
        <div class="events-slider-container">
            <div class="events-slider" id="eventsSlider">
                <div class="event-slide">
                    <img src="https://images.unsplash.com/photo-1540575467063-178a50c2df87?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                        alt="TechFest">
                    <div class="slide-content">
                        <h4>TechFest 2024</h4>
                        <p>Annual Technical Symposium with 50+ inter-college events.</p>
                        <a href="#" class="view-full-btn">View Full <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
                <div class="event-slide">
                    <img src="https://images.unsplash.com/photo-1541339907198-e08756dedf3f?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                        alt="Convocation">
                    <div class="slide-content">
                        <h4>Convocation Ceremony</h4>
                        <p>Batch of 2020-2024 engineering graduation day.</p>
                        <a href="#" class="view-full-btn">View Full <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
                <div class="event-slide">
                    <img src="https://images.unsplash.com/photo-1531482615713-2afd69097998?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                        alt="Hackathon">
                    <div class="slide-content">
                        <h4>State Level Hackathon</h4>
                        <p>24-hour innovation sprint held at GEC Modasa campus.</p>
                        <a href="#" class="view-full-btn">View Full <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="slider-dots" id="sliderDots">
                <!-- Dots will be generated by JS -->
            </div>
        </div>
    </div>

    <!-- 3. Latest Shots Carousel -->
    <div class="latest-shots-card">
        <div class="section-header">
            <h4>Latest Shots</h4>
            <a href="#" class="view-all">View Gallery</a>
        </div>
        <div class="shots-slider-container">
            <div class="shots-slider" id="shotsSlider">
                <div class="shot-slide">
                    <div class="shot-img-wrapper">
                        <img src="https://images.unsplash.com/photo-1485827404703-89b55fcc595e?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                            alt="Robotics & Innovation">
                    </div>
                    <div class="shot-content">
                        <h4>Robotics & Innovation</h4>
                        <p>Students demonstrating autonomous robotics and IoT prototypes.</p>
                    </div>
                </div>
                <div class="shot-slide">
                    <div class="shot-img-wrapper">
                        <img src="https://images.unsplash.com/photo-1461896836934-ffe607ba8211?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                            alt="Annual Sports Tournament">
                    </div>
                    <div class="shot-content">
                        <h4>Annual Sports Meet</h4>
                        <p>Inter-department athletics championship and cricket tournament.</p>
                    </div>
                </div>
                <div class="shot-slide">
                    <div class="shot-img-wrapper">
                        <img src="https://images.unsplash.com/photo-1511578314322-379afb476865?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                            alt="Cultural Youth Fest">
                    </div>
                    <div class="shot-content">
                        <h4>Prarambh Youth Fest</h4>
                        <p>Vibrant stage performances, music, drama, and celebrations.</p>
                    </div>
                </div>
                <div class="shot-slide">
                    <div class="shot-img-wrapper">
                        <img src="https://images.unsplash.com/photo-1581092160607-ee22621dd758?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                            alt="Engineering Workshop">
                    </div>
                    <div class="shot-content">
                        <h4>Engineering Workshop</h4>
                        <p>Hands-on practical machining and metal fabrication sessions.</p>
                    </div>
                </div>
            </div>
            <div class="slider-dots" id="shotsSliderDots">
                <!-- Dots will be generated by JS -->
            </div>
        </div>
    </div>
</section>

<!-- Departments Section -->
<section id="departments" class="section bg-light">
    <div class="full-width-container">
        <div class="section-title text-center">
            <h3>Our Departments</h3>
            <div class="title-underline"></div>
        </div>
        <div class="dept-wrapper">
            <button class="scroll-btn dept-btn left-btn" id="deptLeftBtn" aria-label="Previous Department"><i
                    class="fas fa-chevron-left"></i></button>
            <div class="dept-grid" id="deptGrid">
                <div class="dept-card">
                    <div class="dept-icon"><img src="logos/computer-department.png" alt="Computer Engineering Icon" class="dept-img-icon"></div>
                    <h3>Computer Engineering</h3>
                    <a href="#" class="dept-link">Learn More <i class="fas fa-arrow-right"></i></a>
                </div>
                <div class="dept-card">
                    <div class="dept-icon"><img src="logos/it-department.png" alt="Information Technology Icon" class="dept-img-icon"></div>
                    <h3>Information Technology</h3>
                    <a href="#" class="dept-link">Learn More <i class="fas fa-arrow-right"></i></a>
                </div>
                <div class="dept-card">
                    <div class="dept-icon"><img src="logos/mechanical-department.png" alt="Mechanical Engineering Icon" class="dept-img-icon"></div>
                    <h3>Mechanical Engineering</h3>
                    <a href="#" class="dept-link">Learn More <i class="fas fa-arrow-right"></i></a>
                </div>
                <div class="dept-card">
                    <div class="dept-icon"><img src="logos/automobile-department.png" alt="Automobile Engineering Icon" class="dept-img-icon"></div>
                    <h3>Automobile Engineering</h3>
                    <a href="#" class="dept-link">Learn More <i class="fas fa-arrow-right"></i></a>
                </div>
                <div class="dept-card">
                    <div class="dept-icon"><img src="logos/civil-department.png" alt="Civil Engineering Icon" class="dept-img-icon"></div>
                    <h3>Civil Engineering</h3>
                    <a href="#" class="dept-link">Learn More <i class="fas fa-arrow-right"></i></a>
                </div>
                <div class="dept-card">
                    <div class="dept-icon"><img src="logos/electrical-department.png" alt="Electrical Engineering Icon" class="dept-img-icon"></div>
                    <h3>Electrical Engineering</h3>
                    <a href="#" class="dept-link">Learn More <i class="fas fa-arrow-right"></i></a>
                </div>
                <div class="dept-card">
                    <div class="dept-icon"><img src="logos/ec-department.png" alt="Electronics & Comm. Icon" class="dept-img-icon"></div>
                    <h3>Electronics & Comm.</h3>
                    <a href="#" class="dept-link">Learn More <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>
            <button class="scroll-btn dept-btn right-btn" id="deptRightBtn" aria-label="Next Department"><i
                    class="fas fa-chevron-right"></i></button>
        </div>
    </div>
</section>

<!-- Alumni Section -->
<section id="alumni" class="section alumni-section">
    <div class="full-width-container">
        <div class="section-title text-center">
            <h2>Our Proud Alumni</h2>
            <p>Leading the industry worldwide</p>
            <div class="title-underline"></div>
        </div>

        <div class="alumni-wrapper">
            <button class="scroll-btn left-btn" id="alumniLeftBtn" aria-label="Previous Alumni"><i
                    class="fas fa-chevron-left"></i></button>
            <div class="alumni-carousel" id="alumniCarousel">
                <div class="alumni-card">
                    <img src="https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?ixlib=rb-4.0.3&auto=format&fit=crop&w=256&q=80"
                        alt="Rahul Sharma">
                    <h4>Rahul Sharma</h4>
                    <p class="batch">Computer Engg. &bull; 2015</p>
                    <p class="company">Google, USA</p>
                </div>
                <div class="alumni-card">
                    <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?ixlib=rb-4.0.3&auto=format&fit=crop&w=256&q=80"
                        alt="Priya Patel">
                    <h4>Priya Patel</h4>
                    <p class="batch">IT Engg. &bull; 2018</p>
                    <p class="company">Microsoft, India</p>
                </div>
                <div class="alumni-card">
                    <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?ixlib=rb-4.0.3&auto=format&fit=crop&w=256&q=80"
                        alt="Amit Kumar">
                    <h4>Amit Kumar</h4>
                    <p class="batch">Mechanical Engg. &bull; 2012</p>
                    <p class="company">Tata Motors</p>
                </div>
                <div class="alumni-card">
                    <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-4.0.3&auto=format&fit=crop&w=256&q=80"
                        alt="Sneha Desai">
                    <h4>Sneha Desai</h4>
                    <p class="batch">Civil Engg. &bull; 2016</p>
                    <p class="company">L&T Construction</p>
                </div>
                <div class="alumni-card">
                    <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-4.0.3&auto=format&fit=crop&w=256&q=80"
                        alt="Karan Singh">
                    <h4>Karan Singh</h4>
                    <p class="batch">Electrical Engg. &bull; 2019</p>
                    <p class="company">Reliance Industries</p>
                </div>
                <div class="alumni-card">
                    <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?ixlib=rb-4.0.3&auto=format&fit=crop&w=256&q=80"
                        alt="Pooja Mehta">
                    <h4>Pooja Mehta</h4>
                    <p class="batch">Electronics & Comm. &bull; 2017</p>
                    <p class="company">Intel Corporation</p>
                </div>
                <div class="alumni-card">
                    <img src="https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?ixlib=rb-4.0.3&auto=format&fit=crop&w=256&q=80"
                        alt="Darshan Joshi">
                    <h4>Darshan Joshi</h4>
                    <p class="batch">Automobile Engg. &bull; 2014</p>
                    <p class="company">Mahindra R&D</p>
                </div>
                <div class="alumni-card">
                    <img src="https://images.unsplash.com/photo-1580489944761-15a19d654956?ixlib=rb-4.0.3&auto=format&fit=crop&w=256&q=80"
                        alt="Riya Trivedi">
                    <h4>Riya Trivedi</h4>
                    <p class="batch">Computer Engg. &bull; 2021</p>
                    <p class="company">Amazon AWS</p>
                </div>
            </div>
            <button class="scroll-btn right-btn" id="alumniRightBtn" aria-label="Next Alumni"><i
                    class="fas fa-chevron-right"></i></button>
        </div>
    </div>
</section>

<?php
include_once __DIR__ . '/includes/footer.php';
?>