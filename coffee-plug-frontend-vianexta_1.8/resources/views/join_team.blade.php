@extends('layouts.account_layout ')
<!-- yeild title -->
@section('title', 'Our Team')

@section('content')
    <section class="py-12 sm:py-20  pb-40 h-5/6 ">
        <div class="mx-auto max-w-screen-2xl p-10 ">
            <div class="flex items-center justify-between mb-5 sm:mb-10">
                <h1 class="text-2xl md:text-4xl font-semibold text-secondary text-start "> Our team
                </h1>

            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-2 mb-10 sm:mb-20 min-h-80 pb-2 border-b-2 data-aos="fade-up" data-aos-delay="50" data-aos-duration="1000" data-aos-easing="ease-in-out">
                <div class="sm:col-span-1">
                    <img class="items-center  h-48 w-48 rounded-full md:h-56 md:w-56" src="{{ asset('images/matt.svg') }}"
                        alt="matt">
                </div>
                <div class="sm:col-span-2">
                    <h1 class="mt-4 text-xl md:text-2xl font-semibold text-secondary mb-4 text-start sm:mb-10"> Matt Nam
                    </h1>
                    <p class=" text-secondary  text-base sm:text-start" data-aos-duration="1000" data-aos-delay="800 ">
                        Visionary with a keen ability  to identify
                        opportunities, and leverage strategic partnerships.
                        A serial entrepreneur, Matt has successfully launched innovative platforms that connect buyers
                        and sellers worldwide. He launched Win Win Coffee a coffee importer and roaster, and has grown
                        it into a well-known brand in Philadelphia. His strategic initiatives have propelled exponential
                        growth and empowered his businesses to thrive in a rapidly evolving landscape.


                    </p>
                    <p class=" text-secondary  text-base sm:text-start" data-aos-duration="1000" data-aos-delay="800 "> With
                        a
                        steadfast commitment to inclusivity and sustainability, Matt's vision
                        is reshaping the
                        digital marketplace landscape, creating new possibilities for businesses while driving positive
                        change. His transformative approach is redefining industry standards and positioning him as an
                        influential force in shaping the future of global supply chains.


                    </p>
                </div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-2 mb-10 sm:mb-20 min-h-80 pb-2 border-b-2 data-aos="fade-up" data-aos-delay="50" data-aos-duration="1500" data-aos-easing="ease-in-out">
                <div class="sm:col-span-1">
                    <img class="items-center  h-48 w-48 rounded-full md:h-56 md:w-56"
                        src="{{ asset('images/nikisha.svg') }}" alt="matt">
                </div>
                <div class="sm:col-span-2">
                    <h1 class="mt-4 text-xl md:text-2xl font-semibold text-secondary mb-4 text-start sm:mb-10"> Nikisha
                        Bailey
                    </h1>
                    <p class=" text-secondary  text-base sm:text-start mb-2" data-aos-duration="1000" data-aos-delay="800 ">
                        Strategic leader, and catalyst for operational
                        excellence and systemic change
                    </p>
                    <p class=" text-secondary  text-base sm:text-start mb-2" data-aos-duration="1000" data-aos-delay="800 ">
                        Co-founder of Win Win Coffee, Philadelphia’s first black women led coffee roaster and distributor.
                    </p>
                    <p class=" text-secondary  text-base sm:text-start mb-2" data-aos-duration="1000" data-aos-delay="800 ">
                        With over a decade of experience building and optimizing operations at major recording labels,
                        Nikisha has honed her expertise in driving efficiency, maximizing productivity, and delivering
                        exceptional results.
                    </p>
                    <p class=" text-secondary  text-base sm:text-start mb-2" data-aos-duration="1000" data-aos-delay="800 ">
                        Nikisha's relentless commitment to transformative change has earned her recognition as a standout
                        Forbes Next 1000 Honoree, esteemed Power Player in Billboard Music, and recipient of the prestigious
                        UrbanSkin RX Community Changemaker Award. Her unwavering dedication and influential presence make
                        her an invaluable asset, driving organizational success and fostering exceptional outcomes.
                    </p>

                </div>
            </div>

             <div class="grid grid-cols-1 sm:grid-cols-3 gap-2 mb-10 sm:mb-20 min-h-80 pb-2 border-b-2 data-aos="fade-up" data-aos-delay="50" data-aos-duration="2000" data-aos-easing="ease-in-out">
                <div class="sm:col-span-1">
                    <img class="items-center  h-48 w-48 rounded-full md:h-56 md:w-56"
                        src="{{ asset('images/profiles/steffen.jpg') }}" alt="Steffen">
                </div>
                <div class="sm:col-span-2">
                    <h1 class="mt-4 text-xl md:text-2xl font-semibold text-secondary mb-4 text-start sm:mb-10">Steffen Cornwell
                    </h1>
                    <p class=" text-secondary  text-base sm:text-start mb-2" data-aos-duration="1000" data-aos-delay="800 " data-aos-easing="ease-in-out">
                       Steffen is a backend engineer and product developer based in Philadelphia. 
                       He is also co-founder of Keep.id, a platform to digitally store ID documents for those experiencing homelessness.
                    </p>

                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-2 mb-10 sm:mb-20 min-h-80 pb-2 border-b-2 data-aos="fade-up" data-aos-delay="50" data-aos-duration="2000" data-aos-easing="ease-in-out">
                <div class="sm:col-span-1">
                    <img class="items-center  h-48 w-48 rounded-full md:h-56 md:w-56"
                        src="{{ asset('images/profiles/chuyan.jpg') }}" alt="Chuyan">
                </div>
                <div class="sm:col-span-2">
                    <h1 class="mt-4 text-xl md:text-2xl font-semibold text-secondary mb-4 text-start sm:mb-10">Chuyan Chen
                    </h1>
                    <p class=" text-secondary  text-base sm:text-start mb-2" data-aos-duration="1000" data-aos-delay="800 " data-aos-easing="ease-in-out">
                       Currently a master’s student at University of Pennsylvania pursuing a dual-degree in Nanotechnology & Computer and Information Technology. 
                       Chuyan is familiar with several popular programming languages and have experiences in developing many full-stack projects. 
                    </p>
                    <p class=" text-secondary  text-base sm:text-start mb-2" data-aos-duration="1000" data-aos-delay="800 " data-aos-easing="ease-in-out">
                        With solid software skills, Chuyan has the enthusiasm to leverage my technology and make a contribution to society.
                    </p>

                </div>
            </div>

             <div class="grid grid-cols-1 sm:grid-cols-3 gap-2 mb-10 sm:mb-20 min-h-80 pb-2 border-b-2 data-aos="fade-up" data-aos-delay="50" data-aos-duration="2000" data-aos-easing="ease-in-out">
                <div class="sm:col-span-1">
                    <img class="items-center  h-48 w-48 rounded-full md:h-56 md:w-56"
                        src="{{ asset('images/profiles/solomon.jpg') }}" alt="Solomon">
                </div>
                <div class="sm:col-span-2">
                    <h1 class="mt-4 text-xl md:text-2xl font-semibold text-secondary mb-4 text-start sm:mb-10">Solomon Darko
                    </h1>
                    <p class=" text-secondary  text-base sm:text-start mb-2" data-aos-duration="1000" data-aos-delay="800 " data-aos-easing="ease-in-out">
                       Solomon Darko is a versatile Graphic Designer.
                       His expertise lies in crafting impactful designs, overseeing end-to-end project execution, and managing diverse teams to align creative initiatives with business objectives. 
                    </p>
                    <p class=" text-secondary  text-base sm:text-start mb-2" data-aos-duration="1000" data-aos-delay="800 " data-aos-easing="ease-in-out">
                        With expertise in typography, layout, and color theory, Solomon has a keen eye for creating designs that capture attention and deliver messages effectively. 
                       He is also experienced in Figma, HTML and CSS, enabling him to collaborate seamlessly with developers to bring design concepts to the digital realm.
                    </p>

                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-2 mb-10 sm:mb-20 min-h-80 pb-2 border-b-2 data-aos="fade-up" data-aos-delay="50" data-aos-duration="2000" data-aos-easing="ease-in-out">
                <div class="sm:col-span-1">
                    <img class="items-center  h-48 w-48 rounded-full md:h-56 md:w-56"
                        src="{{ asset('images/profiles/sophia.jpg') }}" alt="Sophia">
                </div>
                <div class="sm:col-span-2">
                    <h1 class="mt-4 text-xl md:text-2xl font-semibold text-secondary mb-4 text-start sm:mb-10">Sophia Ye
                    </h1>
                    <p class=" text-secondary  text-base sm:text-start mb-2" data-aos-duration="1000" data-aos-delay="800 " data-aos-easing="ease-in-out">
                       Sophia is a product designer and frontend engineer based in Pennsylvania. Previously, she worked in product management at a healthtech AI startup.
                    </p>

                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-2 mb-10 sm:mb-20 min-h-80 pb-2 border-b-2 data-aos="fade-up" data-aos-delay="50" data-aos-duration="2000" data-aos-easing="ease-in-out">
                <div class="sm:col-span-1">
                    <img class="items-center  h-48 w-48 rounded-full md:h-56 md:w-56"
                        src="{{ asset('images/profiles/henry.png') }}" alt="Henry">
                </div>
                <div class="sm:col-span-2">
                    <h1 class="mt-4 text-xl md:text-2xl font-semibold text-secondary mb-4 text-start sm:mb-10">Henry Miller
                    </h1>
                    <p class=" text-secondary  text-base sm:text-start mb-2" data-aos-duration="1000" data-aos-delay="800 " data-aos-easing="ease-in-out">
                        Henry Miller is a young computer scientist with diverse work experience, including programming,  software development, and some skill in computer hardware troubleshooting. 
                        Extensive  knowledge of software development cycle as well as proficiency in several programming  languages. 
                        Henry has over seven years of experience in software development. 

                    </p>
                    <p class=" text-secondary  text-base sm:text-start mb-2" data-aos-duration="1000" data-aos-delay="800 " data-aos-easing="ease-in-out">
                        Dedicated to  meeting customer requirements with innovative solutions that maximize efficiency and exceed  capability targets.
                        Consistently use in-depth knowledge of budgetary issues affecting development  and implementation to create cost-effective solutions. 
                        Comfortable discussing technical issues and  solutions with scientists and analysts as well as clients.
                    </p>

                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-2 mb-10 sm:mb-20 min-h-80 pb-2 border-b-2 data-aos="fade-up" data-aos-delay="50" data-aos-duration="2000" data-aos-easing="ease-in-out">
                <div class="sm:col-span-1">
                    <img class="items-center  h-48 w-48 rounded-full md:h-56 md:w-56"
                        src="{{ asset('images/profiles/reya.jpeg') }}" alt="Reya">
                </div>
                <div class="sm:col-span-2">
                    <h1 class="mt-4 text-xl md:text-2xl font-semibold text-secondary mb-4 text-start sm:mb-10">Reya
                    </h1>
                    <p class=" text-secondary  text-base sm:text-start mb-2" data-aos-duration="1000" data-aos-delay="800 " data-aos-easing="ease-in-out">                    
                        Hi, I’m Reya! With three years of experience supporting executives in various industries and a total of 9 years in the BPO field, I bring a wealth of expertise to my role. 
                        As the Executive Assistant, my focus is on keeping things running seamlessly. 

                    </p>
                    <p class=" text-secondary  text-base sm:text-start mb-2" data-aos-duration="1000" data-aos-delay="800 " data-aos-easing="ease-in-out">
                        I handle executive support, calendar management, email coordination, and administrative tasks to ensure the executive owners can concentrate on strategic decisions. 
                        Fueling my work with a love for music and enjoying the aroma of coffee, I find joy in the balance of productivity and pleasure.
                    </p>
                    <p class=" text-secondary  text-base sm:text-start mb-2" data-aos-duration="1000" data-aos-delay="800 " data-aos-easing="ease-in-out">
                        I thrive on a collaborative approach, syncing efforts with the leadership team to contribute to Win Win Coffee's commitment to excellence.
                        Join me in crafting success at Win Win Coffee!

                    </p>

                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-2 mb-10 sm:mb-20 min-h-80 pb-2 border-b-2 data-aos="fade-up" data-aos-delay="50" data-aos-duration="2000" data-aos-easing="ease-in-out">
                <div class="sm:col-span-1">
                    <img class="items-center  h-48 w-48 rounded-full md:h-56 md:w-56"
                        src="{{ asset('images/profiles/jefter.jpg') }}" alt="Jefter">
                </div>
                <div class="sm:col-span-2">
                    <h1 class="mt-4 text-xl md:text-2xl font-semibold text-secondary mb-4 text-start sm:mb-10">Jeffter Donkoh
                    </h1>
                    <p class=" text-secondary  text-base sm:text-start mb-2" data-aos-duration="1000" data-aos-delay="800 " data-aos-easing="ease-in-out">
                        Jeffter Kobby Donkoh is a multifaceted Communications Professional with a diverse skill set spanning Audio and Visual modes of communication,
                        including Live and post-production, Audio Editing, Video Editing, UI/UX, and Graphic Design. 
                        A results-driven personnel with years of experience in cultivating and maintaining strong client relationships. 
                        Proven track record of consistently exceeding sales targets and customer expectations. 

                    </p>
                    <p class=" text-secondary  text-base sm:text-start mb-2" data-aos-duration="1000" data-aos-delay="800 " data-aos-easing="ease-in-out">
                        With significant knowledge in broadcast production, I have also delved into the growing esports industry in Ghana and across Africa. 
                        Over the past five years, my career has evolved to encompass team and community management, as well as startup development.
                    </p>

                </div>
            </div>

            <button class="mt-6 btn btn-outline btn-md border-2 outline-4 text-secondary capitalize ">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6 text-secondary ">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                </svg>
                Go back
            </button>
        </div>

    </section>


@endsection
