<div class="vertical-menu">

    <div data-simplebar class="h-100">


        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title">Menu</li>

                <li>
                    <a href="{{ route('dashboard.index') }}" class="waves-effect">
                        <i class="ri-dashboard-line"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('contact.index') }}" class=" waves-effect">
                        <i class="ri-phone-line"></i>
                        <span>Contact Details</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('contact.us.show') }}" class=" waves-effect">
                        <i class="ri-message-2-fill"></i>
                        <span>Messages</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('lets.talk.show') }}" class=" waves-effect">
                        <i class="ri-message-3-fill"></i>
                        <span>Let's Talk</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.inquiries.index') }}" class=" waves-effect">
                        <i class="ri-inbox-line"></i>
                        <span>All Inquiries</span>
                    </a>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-mail-send-line"></i>
                        <span>Slider Banner</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('slider.index') }}">All Slider Banners</a></li>
                        <li><a href="{{ route('slider.create') }}">Add Slider Banner</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-dashboard-line"></i>
                        <span>Galleries</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('gallery.index') }}">All Galleries</a></li>
                        <li><a href="{{ route('gallery.create') }}">Add Gallery</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-mail-send-line"></i>
                        <span>Services</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('services.index') }}">All Services</a></li>
                        <li><a href="{{ route('services.create') }}">Add Service</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-mail-send-line"></i>
                        <span>About</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('about.index') }}">All About</a></li>
                        <li><a href="{{ route('about.create') }}">Add About</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-layout-3-line"></i>
                        <span>Why Choose Us</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="true">
                        <li><a href="{{ route('why-us.index') }}">All Why Choose Us</a></li>
                        <li><a href="{{ route('why-us.create') }}">Add Why Choose Us</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-account-circle-line"></i>
                        <span>Team Members</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('team.index') }}">All Team</a></li>
                        <li><a href="{{ route('team.create') }}">Add Team Member</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-account-circle-line"></i>
                        <span>FAQs</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('faqs.index') }}">All FAQs</a></li>
                        <li><a href="{{ route('faqs.create') }}">Add FAQs</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-account-circle-line"></i>
                        <span>Testimonials</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('testimonial.index') }}">All Testimonials</a></li>
                        <li><a href="{{ route('testimonial.create') }}">Add Testimonial</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-profile-line"></i>
                        <span>Partners</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('partners.index') }}">All Partners</a></li>
                        <li><a href="{{ route('partners.create') }}">Add Partner</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-profile-line"></i>
                        <span>Success Completion</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('success-story.index') }}">All Success Completion</a></li>
                        <li><a href="{{ route('success-story.create') }}">Add Success Completion</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-profile-line"></i>
                        <span>Project Categories</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('project-category.index') }}">All Project Categories</a></li>
                        <li><a href="{{ route('project-category.create') }}">Add Project Category</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-profile-line"></i>
                        <span>Projects</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('projects.index') }}">All Projects</a></li>
                        <li><a href="{{ route('projects.create') }}">Add Project</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-profile-line"></i>
                        <span>Blog Category</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('blog-category.index') }}">All Blog Category</a></li>
                        <li><a href="{{ route('blog-category.create') }}">Add Blog Category</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-profile-line"></i>
                        <span>Posts</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('posts.index') }}">All Posts</a></li>
                        <li><a href="{{ route('posts.create') }}">Add Post</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-pencil-ruler-2-line"></i>
                        <span>Processes</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('process.index') }}">All Processes</a></li>
                        <li><a href="{{ route('process.create') }}">Add Process</a></li>
                    </ul>
                </li>
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
