
<html>
  <head>
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin="" />
    <link
      rel="stylesheet"
      as="style"
      onload="this.rel='stylesheet'"
      href="https://fonts.googleapis.com/css2?display=swap&amp;family=Lexend%3Awght%40400%3B500%3B700%3B900&amp;family=Noto+Sans%3Awght%40400%3B500%3B700%3B900"
    />

    <title>OSC</title>
    <link rel="icon" type="image/x-icon" href="data:image/x-icon;base64," />

    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
  </head>
  <body>
    <div class="relative flex size-full min-h-screen flex-col bg-white group/design-root overflow-x-hidden" style='font-family: Lexend, "Noto Sans", sans-serif;'>
      <div class="layout-container flex h-full grow flex-col">
        <header class="flex items-center justify-between whitespace-nowrap border-b border-solid border-b-[#f0f2f5] px-10 py-3">
          <div class="flex items-center gap-4 text-[#111518]">
            <div class="size-4">
              <svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4 4H17.3334V17.3334H30.6666V30.6666H44V44H4V4Z" fill="currentColor"></path></svg>
            </div>
            <h2 class="text-[#111518] text-lg font-bold leading-tight tracking-[-0.015em]">Onlie Smart Class</h2>
          </div>
          <div class="flex flex-1 justify-end gap-8">
            <div class="flex items-center gap-9">
              <a class="text-[#111518] text-sm font-medium leading-normal" href="#">Courses</a>
              <a class="text-[#111518] text-sm font-medium leading-normal" href="#">Mentorship</a>
              <a class="text-[#111518] text-sm font-medium leading-normal" href="#">Bootcamps</a>
              <a class="text-[#111518] text-sm font-medium leading-normal" href="#">For Business</a>
              <a class="text-[#111518] text-sm font-medium leading-normal" href="#">Resources</a>
            </div>
            <div class="flex gap-2">
              <button
                class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-xl h-10 px-4 bg-[#2094f3] text-white text-sm font-bold leading-normal tracking-[0.015em]"
              >
                <span class="truncate"><a href="login.php">Login</a></span>
              </button>
              <button
                class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-xl h-10 px-4 bg-[#f0f2f5] text-[#111518] text-sm font-bold leading-normal tracking-[0.015em]"
              >
                <span class="truncate"><a href="register.php">Register</a></span>
              </button>
            </div>
          </div>
        </header>
        <div class="px-40 flex flex-1 justify-center py-5">
          <div class="layout-content-container flex flex-col max-w-[960px] flex-1">
            <div class="@container">
              <div class="@[480px]:p-4">
                <div
                  class="flex min-h-[480px] flex-col gap-6 bg-cover bg-center bg-no-repeat @[480px]:gap-8 @[480px]:rounded-xl items-start justify-end px-4 pb-10 @[480px]:px-10"
                  style='background-image: linear-gradient(rgba(0, 0, 0, 0.1) 0%, rgba(0, 0, 0, 0.4) 100%), url("https://cdn.usegalileo.ai/sdxl10/46151438-4e19-42aa-aaf0-7efdd19722aa.png");'
                >
                  <div class="flex flex-col gap-2 text-left">
                    <h1
                      class="text-white text-4xl font-black leading-tight tracking-[-0.033em] @[480px]:text-5xl @[480px]:font-black @[480px]:leading-tight @[480px]:tracking-[-0.033em]"
                    >
                      Level up your career
                    </h1>
                    <h2 class="text-white text-sm font-normal leading-normal @[480px]:text-base @[480px]:font-normal @[480px]:leading-normal">
                      Learn from top industry professionals and apply your skills in real-world projects
                    </h2>
                  </div>
                  <label class="flex flex-col min-w-40 h-14 w-full max-w-[480px] @[480px]:h-16">
                    <div class="flex w-full flex-1 items-stretch rounded-xl h-full">
                      <div
                        class="text-[#60778a] flex border border-[#dbe1e6] bg-white items-center justify-center pl-[15px] rounded-l-xl border-r-0"
                        data-icon="MagnifyingGlass"
                        data-size="20px"
                        data-weight="regular"
                      >
                        <svg xmlns="http://www.w3.org/2000/svg" width="20px" height="20px" fill="currentColor" viewBox="0 0 256 256">
                          <path
                            d="M229.66,218.34l-50.07-50.06a88.11,88.11,0,1,0-11.31,11.31l50.06,50.07a8,8,0,0,0,11.32-11.32ZM40,112a72,72,0,1,1,72,72A72.08,72.08,0,0,1,40,112Z"
                          ></path>
                        </svg>
                      </div>
                      <input
                        placeholder="What do you want to learn?"
                        class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#111518] focus:outline-0 focus:ring-0 border border-[#dbe1e6] bg-white focus:border-[#dbe1e6] h-full placeholder:text-[#60778a] px-[15px] rounded-r-none border-r-0 pr-2 rounded-l-none border-l-0 pl-2 text-sm font-normal leading-normal @[480px]:text-base @[480px]:font-normal @[480px]:leading-normal"
                        value=""
                      />
                      <div class="flex items-center justify-center rounded-r-xl border-l-0 border border-[#dbe1e6] bg-white pr-[7px]">
                        <button
                          class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-xl h-10 px-4 @[480px]:h-12 @[480px]:px-5 bg-[#2094f3] text-white text-sm font-bold leading-normal tracking-[0.015em] @[480px]:text-base @[480px]:font-bold @[480px]:leading-normal @[480px]:tracking-[0.015em]"
                        >
                          <span class="truncate">Search</span>
                        </button>
                      </div>
                    </div>
                  </label>
                </div>
              </div>
            </div>
            <div class="flex flex-col gap-10 px-4 py-10 @container">
              <div class="flex flex-col gap-4">
                <h1
                  class="text-[#111518] tracking-light text-[32px] font-bold leading-tight @[480px]:text-4xl @[480px]:font-black @[480px]:leading-tight @[480px]:tracking-[-0.033em] max-w-[720px]"
                >
                  Featured Topics
                </h1>
                <p class="text-[#111518] text-base font-normal leading-normal max-w-[720px]">Explore popular topics and find the perfect course for you</p>
              </div>
              <div class="grid grid-cols-[repeat(auto-fit,minmax(158px,1fr))] gap-3 p-0">
                <div class="flex flex-1 gap-3 rounded-lg border border-[#dbe1e6] bg-white p-4 flex-col">
                  <div class="text-[#111518]" data-icon="MonitorPlay" data-size="24px" data-weight="regular">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" fill="currentColor" viewBox="0 0 256 256">
                      <path
                        d="M208,40H48A24,24,0,0,0,24,64V176a24,24,0,0,0,24,24H208a24,24,0,0,0,24-24V64A24,24,0,0,0,208,40Zm8,136a8,8,0,0,1-8,8H48a8,8,0,0,1-8-8V64a8,8,0,0,1,8-8H208a8,8,0,0,1,8,8Zm-48,48a8,8,0,0,1-8,8H96a8,8,0,0,1,0-16h64A8,8,0,0,1,168,224Zm-3.56-110.66-48-32A8,8,0,0,0,104,88v64a8,8,0,0,0,12.44,6.66l48-32a8,8,0,0,0,0-13.32ZM120,137.05V103l25.58,17Z"
                      ></path>
                    </svg>
                  </div>
                  <h2 class="text-[#111518] text-base font-bold leading-tight">Web Development</h2>
                </div>
                <div class="flex flex-1 gap-3 rounded-lg border border-[#dbe1e6] bg-white p-4 flex-col">
                  <div class="text-[#111518]" data-icon="ArrowClockwise" data-size="24px" data-weight="regular">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" fill="currentColor" viewBox="0 0 256 256">
                      <path
                        d="M240,56v48a8,8,0,0,1-8,8H184a8,8,0,0,1,0-16H211.4L184.81,71.64l-.25-.24a80,80,0,1,0-1.67,114.78,8,8,0,0,1,11,11.63A95.44,95.44,0,0,1,128,224h-1.32A96,96,0,1,1,195.75,60L224,85.8V56a8,8,0,1,1,16,0Z"
                      ></path>
                    </svg>
                  </div>
                  <h2 class="text-[#111518] text-base font-bold leading-tight">Software Engineering</h2>
                </div>
                <div class="flex flex-1 gap-3 rounded-lg border border-[#dbe1e6] bg-white p-4 flex-col">
                  <div class="text-[#111518]" data-icon="Trophy" data-size="24px" data-weight="regular">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" fill="currentColor" viewBox="0 0 256 256">
                      <path
                        d="M232,64H208V56a16,16,0,0,0-16-16H64A16,16,0,0,0,48,56v8H24A16,16,0,0,0,8,80V96a40,40,0,0,0,40,40h3.65A80.13,80.13,0,0,0,120,191.61V216H96a8,8,0,0,0,0,16h64a8,8,0,0,0,0-16H136V191.58c31.94-3.23,58.44-25.64,68.08-55.58H208a40,40,0,0,0,40-40V80A16,16,0,0,0,232,64ZM48,120A24,24,0,0,1,24,96V80H48v32q0,4,.39,8Zm144-8.9c0,35.52-28.49,64.64-63.51,64.9H128a64,64,0,0,1-64-64V56H192ZM232,96a24,24,0,0,1-24,24h-.5a81.81,81.81,0,0,0,.5-8.9V80h24Z"
                      ></path>
                    </svg>
                  </div>
                  <h2 class="text-[#111518] text-base font-bold leading-tight">Data Science</h2>
                </div>
                <div class="flex flex-1 gap-3 rounded-lg border border-[#dbe1e6] bg-white p-4 flex-col">
                  <div class="text-[#111518]" data-icon="Briefcase" data-size="24px" data-weight="regular">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" fill="currentColor" viewBox="0 0 256 256">
                      <path
                        d="M216,56H176V48a24,24,0,0,0-24-24H104A24,24,0,0,0,80,48v8H40A16,16,0,0,0,24,72V200a16,16,0,0,0,16,16H216a16,16,0,0,0,16-16V72A16,16,0,0,0,216,56ZM96,48a8,8,0,0,1,8-8h48a8,8,0,0,1,8,8v8H96ZM216,72v41.61A184,184,0,0,1,128,136a184.07,184.07,0,0,1-88-22.38V72Zm0,128H40V131.64A200.19,200.19,0,0,0,128,152a200.25,200.25,0,0,0,88-20.37V200ZM104,112a8,8,0,0,1,8-8h32a8,8,0,0,1,0,16H112A8,8,0,0,1,104,112Z"
                      ></path>
                    </svg>
                  </div>
                  <h2 class="text-[#111518] text-base font-bold leading-tight">Product Management</h2>
                </div>
                <div class="flex flex-1 gap-3 rounded-lg border border-[#dbe1e6] bg-white p-4 flex-col">
                  <div class="text-[#111518]" data-icon="UsersThree" data-size="24px" data-weight="regular">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" fill="currentColor" viewBox="0 0 256 256">
                      <path
                        d="M244.8,150.4a8,8,0,0,1-11.2-1.6A51.6,51.6,0,0,0,192,128a8,8,0,0,1-7.37-4.89,8,8,0,0,1,0-6.22A8,8,0,0,1,192,112a24,24,0,1,0-23.24-30,8,8,0,1,1-15.5-4A40,40,0,1,1,219,117.51a67.94,67.94,0,0,1,27.43,21.68A8,8,0,0,1,244.8,150.4ZM190.92,212a8,8,0,1,1-13.84,8,57,57,0,0,0-98.16,0,8,8,0,1,1-13.84-8,72.06,72.06,0,0,1,33.74-29.92,48,48,0,1,1,58.36,0A72.06,72.06,0,0,1,190.92,212ZM128,176a32,32,0,1,0-32-32A32,32,0,0,0,128,176ZM72,120a8,8,0,0,0-8-8A24,24,0,1,1,87.24,82a8,8,0,1,0,15.5-4A40,40,0,1,0,37,117.51,67.94,67.94,0,0,0,9.6,139.19a8,8,0,1,0,12.8,9.61A51.6,51.6,0,0,1,64,128,8,8,0,0,0,72,120Z"
                      ></path>
                    </svg>
                  </div>
                  <h2 class="text-[#111518] text-base font-bold leading-tight">User Experience Design</h2>
                </div>
                <div class="flex flex-1 gap-3 rounded-lg border border-[#dbe1e6] bg-white p-4 flex-col">
                  <div class="text-[#111518]" data-icon="Shield" data-size="24px" data-weight="regular">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" fill="currentColor" viewBox="0 0 256 256">
                      <path
                        d="M208,40H48A16,16,0,0,0,32,56v58.77c0,89.61,75.82,119.34,91,124.39a15.53,15.53,0,0,0,10,0c15.2-5.05,91-34.78,91-124.39V56A16,16,0,0,0,208,40Zm0,74.79c0,78.42-66.35,104.62-80,109.18-13.53-4.51-80-30.69-80-109.18V56l160,0Z"
                      ></path>
                    </svg>
                  </div>
                  <h2 class="text-[#111518] text-base font-bold leading-tight">Digital Marketing</h2>
                </div>
                <div class="flex flex-1 gap-3 rounded-lg border border-[#dbe1e6] bg-white p-4 flex-col">
                  <div class="text-[#111518]" data-icon="PencilSimple" data-size="24px" data-weight="regular">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" fill="currentColor" viewBox="0 0 256 256">
                      <path
                        d="M227.31,73.37,182.63,28.68a16,16,0,0,0-22.63,0L36.69,152A15.86,15.86,0,0,0,32,163.31V208a16,16,0,0,0,16,16H92.69A15.86,15.86,0,0,0,104,219.31L227.31,96a16,16,0,0,0,0-22.63ZM92.69,208H48V163.31l88-88L180.69,120ZM192,108.68,147.31,64l24-24L216,84.68Z"
                      ></path>
                    </svg>
                  </div>
                  <h2 class="text-[#111518] text-base font-bold leading-tight">Creative Writing</h2>
                </div>
                <div class="flex flex-1 gap-3 rounded-lg border border-[#dbe1e6] bg-white p-4 flex-col">
                  <div class="text-[#111518]" data-icon="ChartLine" data-size="24px" data-weight="regular">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" fill="currentColor" viewBox="0 0 256 256">
                      <path
                        d="M232,208a8,8,0,0,1-8,8H32a8,8,0,0,1-8-8V48a8,8,0,0,1,16,0v94.37L90.73,98a8,8,0,0,1,10.07-.38l58.81,44.11L218.73,90a8,8,0,1,1,10.54,12l-64,56a8,8,0,0,1-10.07.38L96.39,114.29,40,163.63V200H224A8,8,0,0,1,232,208Z"
                      ></path>
                    </svg>
                  </div>
                  <h2 class="text-[#111518] text-base font-bold leading-tight">Business Strategy</h2>
                </div>
                <div class="flex flex-1 gap-3 rounded-lg border border-[#dbe1e6] bg-white p-4 flex-col">
                  <div class="text-[#111518]" data-icon="Globe" data-size="24px" data-weight="regular">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" fill="currentColor" viewBox="0 0 256 256">
                      <path
                        d="M128,24A104,104,0,1,0,232,128,104.11,104.11,0,0,0,128,24ZM101.63,168h52.74C149,186.34,140,202.87,128,215.89,116,202.87,107,186.34,101.63,168ZM98,152a145.72,145.72,0,0,1,0-48h60a145.72,145.72,0,0,1,0,48ZM40,128a87.61,87.61,0,0,1,3.33-24H81.79a161.79,161.79,0,0,0,0,48H43.33A87.61,87.61,0,0,1,40,128ZM154.37,88H101.63C107,69.66,116,53.13,128,40.11,140,53.13,149,69.66,154.37,88Zm19.84,16h38.46a88.15,88.15,0,0,1,0,48H174.21a161.79,161.79,0,0,0,0-48Zm32.16-16H170.94a142.39,142.39,0,0,0-20.26-45A88.37,88.37,0,0,1,206.37,88ZM105.32,43A142.39,142.39,0,0,0,85.06,88H49.63A88.37,88.37,0,0,1,105.32,43ZM49.63,168H85.06a142.39,142.39,0,0,0,20.26,45A88.37,88.37,0,0,1,49.63,168Zm101.05,45a142.39,142.39,0,0,0,20.26-45h35.43A88.37,88.37,0,0,1,150.68,213Z"
                      ></path>
                    </svg>
                  </div>
                  <h2 class="text-[#111518] text-base font-bold leading-tight">Global Language</h2>
                </div>
                <div class="flex flex-1 gap-3 rounded-lg border border-[#dbe1e6] bg-white p-4 flex-col">
                  <div class="text-[#111518]" data-icon="MusicNotes" data-size="24px" data-weight="regular">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" fill="currentColor" viewBox="0 0 256 256">
                      <path
                        d="M212.92,25.69a8,8,0,0,0-6.86-1.45l-128,32A8,8,0,0,0,72,64V174.08A36,36,0,1,0,88,204V118.25l112-28v51.83A36,36,0,1,0,216,172V32A8,8,0,0,0,212.92,25.69ZM52,224a20,20,0,1,1,20-20A20,20,0,0,1,52,224ZM88,101.75V70.25l112-28v31.5ZM180,192a20,20,0,1,1,20-20A20,20,0,0,1,180,192Z"
                      ></path>
                    </svg>
                  </div>
                  <h2 class="text-[#111518] text-base font-bold leading-tight">Music Production</h2>
                </div>
                <div class="flex flex-1 gap-3 rounded-lg border border-[#dbe1e6] bg-white p-4 flex-col">
                  <div class="text-[#111518]" data-icon="PaintBrush" data-size="24px" data-weight="regular">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" fill="currentColor" viewBox="0 0 256 256">
                      <path
                        d="M232,32a8,8,0,0,0-8-8c-44.08,0-89.31,49.71-114.43,82.63A60,60,0,0,0,32,164c0,30.88-19.54,44.73-20.47,45.37A8,8,0,0,0,16,224H92a60,60,0,0,0,57.37-77.57C182.3,121.31,232,76.08,232,32ZM92,208H34.63C41.38,198.41,48,183.92,48,164a44,44,0,1,1,44,44Zm32.42-94.45q5.14-6.66,10.09-12.55A76.23,76.23,0,0,1,155,121.49q-5.9,4.94-12.55,10.09A60.54,60.54,0,0,0,124.42,113.55Zm42.7-2.68a92.57,92.57,0,0,0-22-22c31.78-34.53,55.75-45,69.9-47.91C212.17,55.12,201.65,79.09,167.12,110.87Z"
                      ></path>
                    </svg>
                  </div>
                  <h2 class="text-[#111518] text-base font-bold leading-tight">Graphic Design</h2>
                </div>
                <div class="flex flex-1 gap-3 rounded-lg border border-[#dbe1e6] bg-white p-4 flex-col">
                  <div class="text-[#111518]" data-icon="StackSimple" data-size="24px" data-weight="regular">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" fill="currentColor" viewBox="0 0 256 256">
                      <path
                        d="M12,111l112,64a8,8,0,0,0,7.94,0l112-64a8,8,0,0,0,0-13.9l-112-64a8,8,0,0,0-7.94,0l-112,64A8,8,0,0,0,12,111ZM128,49.21,223.87,104,128,158.79,32.13,104ZM246.94,140A8,8,0,0,1,244,151L132,215a8,8,0,0,1-7.94,0L12,151A8,8,0,0,1,20,137.05l108,61.74,108-61.74A8,8,0,0,1,246.94,140Z"
                      ></path>
                    </svg>
                  </div>
                  <h2 class="text-[#111518] text-base font-bold leading-tight">3D Animation</h2>
                </div>
                <div class="flex flex-1 gap-3 rounded-lg border border-[#dbe1e6] bg-white p-4 flex-col">
                  <div class="text-[#111518]" data-icon="CodeSimple" data-size="24px" data-weight="regular">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" fill="currentColor" viewBox="0 0 256 256">
                      <path
                        d="M93.31,70,28,128l65.27,58a8,8,0,1,1-10.62,12l-72-64a8,8,0,0,1,0-12l72-64A8,8,0,1,1,93.31,70Zm152,52-72-64a8,8,0,0,0-10.62,12L228,128l-65.27,58a8,8,0,1,0,10.62,12l72-64a8,8,0,0,0,0-12Z"
                      ></path>
                    </svg>
                  </div>
                  <h2 class="text-[#111518] text-base font-bold leading-tight">Game Development</h2>
                </div>
                <div class="flex flex-1 gap-3 rounded-lg border border-[#dbe1e6] bg-white p-4 flex-col">
                  <div class="text-[#111518]" data-icon="Camera" data-size="24px" data-weight="regular">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" fill="currentColor" viewBox="0 0 256 256">
                      <path
                        d="M208,56H180.28L166.65,35.56A8,8,0,0,0,160,32H96a8,8,0,0,0-6.65,3.56L75.71,56H48A24,24,0,0,0,24,80V192a24,24,0,0,0,24,24H208a24,24,0,0,0,24-24V80A24,24,0,0,0,208,56Zm8,136a8,8,0,0,1-8,8H48a8,8,0,0,1-8-8V80a8,8,0,0,1,8-8H80a8,8,0,0,0,6.66-3.56L100.28,48h55.43l13.63,20.44A8,8,0,0,0,176,72h32a8,8,0,0,1,8,8ZM128,88a44,44,0,1,0,44,44A44.05,44.05,0,0,0,128,88Zm0,72a28,28,0,1,1,28-28A28,28,0,0,1,128,160Z"
                      ></path>
                    </svg>
                  </div>
                  <h2 class="text-[#111518] text-base font-bold leading-tight">Photography</h2>
                </div>
                <div class="flex flex-1 gap-3 rounded-lg border border-[#dbe1e6] bg-white p-4 flex-col">
                  <div class="text-[#111518]" data-icon="Book" data-size="24px" data-weight="regular">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" fill="currentColor" viewBox="0 0 256 256">
                      <path
                        d="M208,24H72A32,32,0,0,0,40,56V224a8,8,0,0,0,8,8H192a8,8,0,0,0,0-16H56a16,16,0,0,1,16-16H208a8,8,0,0,0,8-8V32A8,8,0,0,0,208,24Zm-8,160H72a31.82,31.82,0,0,0-16,4.29V56A16,16,0,0,1,72,40H200Z"
                      ></path>
                    </svg>
                  </div>
                  <h2 class="text-[#111518] text-base font-bold leading-tight">Literature</h2>
                </div>
                <div class="flex flex-1 gap-3 rounded-lg border border-[#dbe1e6] bg-white p-4 flex-col">
                  <div class="text-[#111518]" data-icon="Basketball" data-size="24px" data-weight="regular">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" fill="currentColor" viewBox="0 0 256 256">
                      <path
                        d="M128,24A104,104,0,1,0,232,128,104.11,104.11,0,0,0,128,24ZM60,72.17A87.2,87.2,0,0,1,79.63,120H40.37A87.54,87.54,0,0,1,60,72.17ZM136,120V40.37a87.59,87.59,0,0,1,48.68,20.37A103.06,103.06,0,0,0,160.3,120Zm-16,0H95.7A103.06,103.06,0,0,0,71.32,60.74,87.59,87.59,0,0,1,120,40.37ZM79.63,136A87.2,87.2,0,0,1,60,183.83,87.54,87.54,0,0,1,40.37,136Zm16.07,0H120v79.63a87.59,87.59,0,0,1-48.68-20.37A103.09,103.09,0,0,0,95.7,136Zm40.3,0h24.3a103.09,103.09,0,0,0,24.38,59.26A87.59,87.59,0,0,1,136,215.63Zm40.37,0h39.26A87.54,87.54,0,0,1,196,183.83,87.2,87.2,0,0,1,176.37,136Zm0-16A87.2,87.2,0,0,1,196,72.17,87.54,87.54,0,0,1,215.63,120Z"
                      ></path>
                    </svg>
                  </div>
                  <h2 class="text-[#111518] text-base font-bold leading-tight">Sports Management</h2>
                </div>
                <div class="flex flex-1 gap-3 rounded-lg border border-[#dbe1e6] bg-white p-4 flex-col">
                  <div class="text-[#111518]" data-icon="Bicycle" data-size="24px" data-weight="regular">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" fill="currentColor" viewBox="0 0 256 256">
                      <path
                        d="M208,112a47.81,47.81,0,0,0-16.93,3.09L165.93,72H192a8,8,0,0,1,8,8,8,8,0,0,0,16,0,24,24,0,0,0-24-24H152a8,8,0,0,0-6.91,12l11.65,20H99.26L82.91,60A8,8,0,0,0,76,56H48a8,8,0,0,0,0,16H71.41L85.12,95.51,69.41,117.06a48.13,48.13,0,1,0,12.92,9.44l11.59-15.9L125.09,164A8,8,0,1,0,138.91,156l-30.32-52h57.48l11.19,19.17A48,48,0,1,0,208,112ZM80,160a32,32,0,1,1-20.21-29.74l-18.25,25a8,8,0,1,0,12.92,9.42l18.25-25A31.88,31.88,0,0,1,80,160Zm128,32a32,32,0,0,1-22.51-54.72L201.09,164A8,8,0,1,0,214.91,156L199.3,129.21A32,32,0,1,1,208,192Z"
                      ></path>
                    </svg>
                  </div>
                  <h2 class="text-[#111518] text-base font-bold leading-tight">Cycling</h2>
                </div>
                <div class="flex flex-1 gap-3 rounded-lg border border-[#dbe1e6] bg-white p-4 flex-col">
                  <div class="text-[#111518]" data-icon="Knife" data-size="24px" data-weight="regular">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" fill="currentColor" viewBox="0 0 256 256">
                      <path
                        d="M231.81,32.19a28,28,0,0,0-39.67.07L18.27,210.6A8,8,0,0,0,22.2,224a154.93,154.93,0,0,0,35,4c33.42,0,66.88-10.88,98.33-32.21,31.75-21.53,50.15-45.85,50.92-46.88a8,8,0,0,0-.74-10.46l-18.74-18.76,45-48A28.08,28.08,0,0,0,231.81,32.19ZM189.22,144.63a225.51,225.51,0,0,1-43.11,38.18c-34.47,23.25-70,32.7-105.84,28.16l106.3-109ZM220.5,60.5l-.18.19-44.71,47.67L157.74,90.47l45.78-47a12,12,0,0,1,17,17Z"
                      ></path>
                    </svg>
                  </div>
                  <h2 class="text-[#111518] text-base font-bold leading-tight">Culinary Arts</h2>
                </div>
                <div class="flex flex-1 gap-3 rounded-lg border border-[#dbe1e6] bg-white p-4 flex-col">
                  <div class="text-[#111518]" data-icon="Headphones" data-size="24px" data-weight="regular">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" fill="currentColor" viewBox="0 0 256 256">
                      <path
                        d="M201.89,62.66A103.43,103.43,0,0,0,128.79,32H128A104,104,0,0,0,24,136v56a24,24,0,0,0,24,24H64a24,24,0,0,0,24-24V152a24,24,0,0,0-24-24H40.36A88,88,0,0,1,128,48h.67a87.71,87.71,0,0,1,87,80H192a24,24,0,0,0-24,24v40a24,24,0,0,0,24,24h16a24,24,0,0,0,24-24V136A103.41,103.41,0,0,0,201.89,62.66ZM64,144a8,8,0,0,1,8,8v40a8,8,0,0,1-8,8H48a8,8,0,0,1-8-8V144Zm152,48a8,8,0,0,1-8,8H192a8,8,0,0,1-8-8V152a8,8,0,0,1,8-8h24Z"
                      ></path>
                    </svg>
                  </div>
                  <h2 class="text-[#111518] text-base font-bold leading-tight">Sound Engineering</h2>
                </div>
                <div class="flex flex-1 gap-3 rounded-lg border border-[#dbe1e6] bg-white p-4 flex-col">
                  <div class="text-[#111518]" data-icon="Flask" data-size="24px" data-weight="regular">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" fill="currentColor" viewBox="0 0 256 256">
                      <path
                        d="M221.69,199.77,160,96.92V40h8a8,8,0,0,0,0-16H88a8,8,0,0,0,0,16h8V96.92L34.31,199.77A16,16,0,0,0,48,224H208a16,16,0,0,0,13.72-24.23ZM110.86,103.25A7.93,7.93,0,0,0,112,99.14V40h32V99.14a7.93,7.93,0,0,0,1.14,4.11L183.36,167c-12,2.37-29.07,1.37-51.75-10.11-15.91-8.05-31.05-12.32-45.22-12.81ZM48,208l28.54-47.58c14.25-1.74,30.31,1.85,47.82,10.72,19,9.61,35,12.88,48,12.88a69.89,69.89,0,0,0,19.55-2.7L208,208Z"
                      ></path>
                    </svg>
                  </div>
                  <h2 class="text-[#111518] text-base font-bold leading-tight">Chemistry</h2>
                </div>
                <div class="flex flex-1 gap-3 rounded-lg border border-[#dbe1e6] bg-white p-4 flex-col">
                  <div class="text-[#111518]" data-icon="Guitar" data-size="24px" data-weight="regular">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" fill="currentColor" viewBox="0 0 256 256">
                      <path
                        d="M245.66,42.34l-32-32a8,8,0,0,0-12.72,9.41L140.52,80.16C117.73,68.3,92.21,69.29,76.75,84.74a42.27,42.27,0,0,0-9.39,14.37A8.24,8.24,0,0,1,59.81,104c-14.59.49-27.26,5.72-36.65,15.11C11.08,131.22,6,148.6,8.74,168.07,11.4,186.7,21.07,205.15,36,220s33.34,24.56,52,27.22A71.13,71.13,0,0,0,98.1,248c15.32,0,28.83-5.23,38.76-15.16,9.39-9.39,14.62-22.06,15.11-36.65a8.24,8.24,0,0,1,4.92-7.55,42.22,42.22,0,0,0,14.37-9.39c15.45-15.46,16.44-41,4.58-63.77l60.41-60.42a8,8,0,0,0,9.41-12.72ZM200,68.68,187.32,56,212,31.31,224.69,44ZM160,167.93a26.12,26.12,0,0,1-8.95,5.83,24.24,24.24,0,0,0-15,21.89c-.36,10.46-4,19.41-10.43,25.88-8.44,8.43-21,11.95-35.36,9.89C75,229.25,59.73,221.19,47.27,208.73S26.75,181,24.58,165.81c-2-14.37,1.46-26.92,9.89-35.36C40.94,124,49.89,120.38,60.35,120h0a24.22,24.22,0,0,0,21.89-15,26.12,26.12,0,0,1,5.83-9c5.49-5.49,13-8.13,21.38-8.13a49.38,49.38,0,0,1,19.13,4.19L108.5,112.19a32,32,0,1,0,35.31,35.31l20.08-20.08C170.41,142.71,169.47,158.41,160,167.93Zm-10.4-61.48a72.9,72.9,0,0,1,5.93,6.75l-15.42,15.42a32.22,32.22,0,0,0-12.68-12.68l15.42-15.43A73,73,0,0,1,149.55,106.45ZM112,128a16,16,0,0,1,16,16h0a16,16,0,1,1-16-16Zm48.85-32.85a85.23,85.23,0,0,0-6.69-6L176,67.31,188.69,80l-21.83,21.82A86.94,86.94,0,0,0,160.86,95.14Zm-67.2,99.19a8,8,0,0,1-11.31,11.32l-32-32a8,8,0,0,1,11.32-11.31Z"
                      ></path>
                    </svg>
                  </div>
                  <h2 class="text-[#111518] text-base font-bold leading-tight">Guitar Performance</h2>
                </div>
                <div class="flex flex-1 gap-3 rounded-lg border border-[#dbe1e6] bg-white p-4 flex-col">
                  <div class="text-[#111518]" data-icon="Hammer" data-size="24px" data-weight="regular">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" fill="currentColor" viewBox="0 0 256 256">
                      <path
                        d="M251.34,112,183.88,44.08a96.1,96.1,0,0,0-135.77,0l-.09.09L34.25,58.4A8,8,0,0,0,45.74,69.53L59.47,55.35a79.92,79.92,0,0,1,18.71-13.9L124.68,88l-96,96a16,16,0,0,0,0,22.63l20.69,20.69a16,16,0,0,0,22.63,0l96-96,14.34,14.34h0L200,163.3a16,16,0,0,0,22.63,0l28.69-28.69A16,16,0,0,0,251.34,112ZM60.68,216,40,195.31l68-68L128.68,148ZM162.34,114.32,140,136.67,119.31,116l22.35-22.35a8,8,0,0,0,0-11.32L94.32,35a80,80,0,0,1,78.23,20.41l44.22,44.51L188,128.66l-14.34-14.34A8,8,0,0,0,162.34,114.32Zm49,37.66-12-12L228,111.25l12,12Z"
                      ></path>
                    </svg>
                  </div>
                  <h2 class="text-[#111518] text-base font-bold leading-tight">Woodworking</h2>
                </div>
                <div class="flex flex-1 gap-3 rounded-lg border border-[#dbe1e6] bg-white p-4 flex-col">
                  <div class="text-[#111518]" data-icon="Leaf" data-size="24px" data-weight="regular">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" fill="currentColor" viewBox="0 0 256 256">
                      <path
                        d="M223.45,40.07a8,8,0,0,0-7.52-7.52C139.8,28.08,78.82,51,52.82,94a87.09,87.09,0,0,0-12.76,49c.57,15.92,5.21,32,13.79,47.85l-19.51,19.5a8,8,0,0,0,11.32,11.32l19.5-19.51C81,210.73,97.09,215.37,113,215.94q1.67.06,3.33.06A86.93,86.93,0,0,0,162,203.18C205,177.18,227.93,116.21,223.45,40.07ZM153.75,189.5c-22.75,13.78-49.68,14-76.71.77l88.63-88.62a8,8,0,0,0-11.32-11.32L65.73,179c-13.19-27-13-54,.77-76.71,22.09-36.47,74.6-56.44,141.31-54.06C210.2,114.89,190.22,167.41,153.75,189.5Z"
                      ></path>
                    </svg>
                  </div>
                  <h2 class="text-[#111518] text-base font-bold leading-tight">Botany</h2>
                </div>
                <div class="flex flex-1 gap-3 rounded-lg border border-[#dbe1e6] bg-white p-4 flex-col">
                  <div class="text-[#111518]" data-icon="Megaphone" data-size="24px" data-weight="regular">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" fill="currentColor" viewBox="0 0 256 256">
                      <path
                        d="M240,120a48.05,48.05,0,0,0-48-48H152.2c-2.91-.17-53.62-3.74-101.91-44.24A16,16,0,0,0,24,40V200a16,16,0,0,0,26.29,12.25c37.77-31.68,77-40.76,93.71-43.3v31.72A16,16,0,0,0,151.12,214l11,7.33A16,16,0,0,0,186.5,212l11.77-44.36A48.07,48.07,0,0,0,240,120ZM40,199.93V40h0c42.81,35.91,86.63,45,104,47.24v65.48C126.65,155,82.84,164.07,40,199.93Zm131,8,0,.11-11-7.33V168h21.6ZM192,152H160V88h32a32,32,0,1,1,0,64Z"
                      ></path>
                    </svg>
                  </div>
                  <h2 class="text-[#111518] text-base font-bold leading-tight">Public Speaking</h2>
                </div>
                <div class="flex flex-1 gap-3 rounded-lg border border-[#dbe1e6] bg-white p-4 flex-col">
                  <div class="text-[#111518]" data-icon="Mountains" data-size="24px" data-weight="regular">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" fill="currentColor" viewBox="0 0 256 256">
                      <path
                        d="M164,80a28,28,0,1,0-28-28A28,28,0,0,0,164,80Zm0-40a12,12,0,1,1-12,12A12,12,0,0,1,164,40Zm90.88,155.92-54.56-92.08A15.87,15.87,0,0,0,186.55,96h0a15.85,15.85,0,0,0-13.76,7.84L146.63,148l-44.84-76.1a16,16,0,0,0-27.58,0L1.11,195.94A8,8,0,0,0,8,208H248a8,8,0,0,0,6.88-12.08ZM88,80l23.57,40H64.43ZM22,192l33-56h66l18.74,31.8,0,0L154,192Zm150.57,0-16.66-28.28L186.55,112,234,192Z"
                      ></path>
                    </svg>
                  </div>
                  <h2 class="text-[#111518] text-base font-bold leading-tight">Geology</h2>
                </div>
                <div class="flex flex-1 gap-3 rounded-lg border border-[#dbe1e6] bg-white p-4 flex-col">
                  <div class="text-[#111518]" data-icon="Palette" data-size="24px" data-weight="regular">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" fill="currentColor" viewBox="0 0 256 256">
                      <path
                        d="M200.77,53.89A103.27,103.27,0,0,0,128,24h-1.07A104,104,0,0,0,24,128c0,43,26.58,79.06,69.36,94.17A32,32,0,0,0,136,192a16,16,0,0,1,16-16h46.21a31.81,31.81,0,0,0,31.2-24.88,104.43,104.43,0,0,0,2.59-24A103.28,103.28,0,0,0,200.77,53.89Zm13,93.71A15.89,15.89,0,0,1,198.21,160H152a32,32,0,0,0-32,32,16,16,0,0,1-21.31,15.07C62.49,194.3,40,164,40,128a88,88,0,0,1,87.09-88h.9a88.35,88.35,0,0,1,88,87.25A88.86,88.86,0,0,1,213.81,147.6ZM140,76a12,12,0,1,1-12-12A12,12,0,0,1,140,76ZM96,100A12,12,0,1,1,84,88,12,12,0,0,1,96,100Zm0,56a12,12,0,1,1-12-12A12,12,0,0,1,96,156Zm88-56a12,12,0,1,1-12-12A12,12,0,0,1,184,100Z"
                      ></path>
                    </svg>
                  </div>
                  <h2 class="text-[#111518] text-base font-bold leading-tight">Fashion Design</h2>
                </div>
                <div class="flex flex-1 gap-3 rounded-lg border border-[#dbe1e6] bg-white p-4 flex-col">
                  <div class="text-[#111518]" data-icon="CrownSimple" data-size="24px" data-weight="regular">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" fill="currentColor" viewBox="0 0 256 256">
                      <path
                        d="M243.84,76.19a12.08,12.08,0,0,0-13.34-1.7l-50.21,25L138.37,29.86a12.11,12.11,0,0,0-20.74,0L75.71,99.52l-50.19-25A12.11,12.11,0,0,0,8.62,89.12l37,113.36a8,8,0,0,0,11.68,4.4C57.55,206.73,83.12,192,128,192s70.45,14.73,70.68,14.87a8,8,0,0,0,11.71-4.39l37-113.33A12.06,12.06,0,0,0,243.84,76.19ZM198,188.83C186,183.74,162.08,176,128,176s-58,7.74-70,12.83L26.71,93l45.07,22.47a12.17,12.17,0,0,0,15.78-4.59L128,43.66l40.44,67.2a12.17,12.17,0,0,0,15.77,4.59L229.29,93Z"
                      ></path>
                    </svg>
                  </div>
                  <h2 class="text-[#111518] text-base font-bold leading-tight">Urban Planning</h2>
                </div>
                <div class="flex flex-1 gap-3 rounded-lg border border-[#dbe1e6] bg-white p-4 flex-col">
                  <div class="text-[#111518]" data-icon="Rocket" data-size="24px" data-weight="regular">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" fill="currentColor" viewBox="0 0 256 256">
                      <path
                        d="M152,224a8,8,0,0,1-8,8H112a8,8,0,0,1,0-16h32A8,8,0,0,1,152,224ZM128,112a12,12,0,1,0-12-12A12,12,0,0,0,128,112Zm95.62,43.83-12.36,55.63a16,16,0,0,1-25.51,9.11L158.51,200h-61L70.25,220.57a16,16,0,0,1-25.51-9.11L32.38,155.83a16.09,16.09,0,0,1,3.32-13.71l28.56-34.26a123.07,123.07,0,0,1,8.57-36.67c12.9-32.34,36-52.63,45.37-59.85a16,16,0,0,1,19.6,0c9.34,7.22,32.47,27.51,45.37,59.85a123.07,123.07,0,0,1,8.57,36.67l28.56,34.26A16.09,16.09,0,0,1,223.62,155.83ZM99.43,184h57.14c21.12-37.54,25.07-73.48,11.74-106.88C156.55,47.64,134.49,29,128,24c-6.51,5-28.57,23.64-40.33,53.12C74.36,110.52,78.31,146.46,99.43,184Zm-15,5.85Q68.28,160.5,64.83,132.16L48,152.36,60.36,208l.18-.13ZM208,152.36l-16.83-20.2q-3.42,28.28-19.56,57.69l23.85,18,.18.13Z"
                      ></path>
                    </svg>
                  </div>
                  <h2 class="text-[#111518] text-base font-bold leading-tight">Astronomy</h2>
                </div>
                <div class="flex flex-1 gap-3 rounded-lg border border-[#dbe1e6] bg-white p-4 flex-col">
                  <div class="text-[#111518]" data-icon="Scissors" data-size="24px" data-weight="regular">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" fill="currentColor" viewBox="0 0 256 256">
                      <path
                        d="M157.73,113.13A8,8,0,0,1,159.82,102L227.48,55.7a8,8,0,0,1,9,13.21l-67.67,46.3a7.92,7.92,0,0,1-4.51,1.4A8,8,0,0,1,157.73,113.13Zm80.87,85.09a8,8,0,0,1-11.12,2.08L136,137.7,93.49,166.78a36,36,0,1,1-9-13.19L121.83,128,84.44,102.41a35.86,35.86,0,1,1,9-13.19l143,97.87A8,8,0,0,1,238.6,198.22ZM80,180a20,20,0,1,0-5.86,14.14A19.85,19.85,0,0,0,80,180ZM74.14,90.13a20,20,0,1,0-28.28,0A19.85,19.85,0,0,0,74.14,90.13Z"
                      ></path>
                    </svg>
                  </div>
                  <h2 class="text-[#111518] text-base font-bold leading-tight">Home Renovation</h2>
                </div>
                <div class="flex flex-1 gap-3 rounded-lg border border-[#dbe1e6] bg-white p-4 flex-col">
                  <div class="text-[#111518]" data-icon="Skull" data-size="24px" data-weight="regular">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" fill="currentColor" viewBox="0 0 256 256">
                      <path
                        d="M92,104a28,28,0,1,0,28,28A28,28,0,0,0,92,104Zm0,40a12,12,0,1,1,12-12A12,12,0,0,1,92,144Zm72-40a28,28,0,1,0,28,28A28,28,0,0,0,164,104Zm0,40a12,12,0,1,1,12-12A12,12,0,0,1,164,144ZM128,16C70.65,16,24,60.86,24,116c0,34.1,18.27,66,48,84.28V216a16,16,0,0,0,16,16h80a16,16,0,0,0,16-16V200.28C213.73,182,232,150.1,232,116,232,60.86,185.35,16,128,16Zm44.12,172.69a8,8,0,0,0-4.12,7V216H152V192a8,8,0,0,0-16,0v24H120V192a8,8,0,0,0-16,0v24H88V195.69a8,8,0,0,0-4.12-7C56.81,173.69,40,145.84,40,116c0-46.32,39.48-84,88-84s88,37.68,88,84C216,145.83,199.19,173.69,172.12,188.69Z"
                      ></path>
                    </svg>
                  </div>
                  <h2 class="text-[#111518] text-base font-bold leading-tight">Scuba Diving</h2>
                </div>
                <div class="flex flex-1 gap-3 rounded-lg border border-[#dbe1e6] bg-white p-4 flex-col">
                  <div class="text-[#111518]" data-icon="SoccerBall" data-size="24px" data-weight="regular">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" fill="currentColor" viewBox="0 0 256 256">
                      <path
                        d="M128,24A104,104,0,1,0,232,128,104.11,104.11,0,0,0,128,24Zm76.52,147.42H170.9l-9.26-12.76,12.63-36.78,15-4.89,26.24,20.13A87.38,87.38,0,0,1,204.52,171.42Zm-164-34.3L66.71,117l15,4.89,12.63,36.78L85.1,171.42H51.48A87.38,87.38,0,0,1,40.47,137.12Zm10-50.64,5.51,18.6L40.71,116.77A87.33,87.33,0,0,1,50.43,86.48ZM109,152,97.54,118.65,128,97.71l30.46,20.94L147,152Zm91.07-46.92,5.51-18.6a87.33,87.33,0,0,1,9.72,30.29Zm-6.2-35.38-9.51,32.08-15.07,4.89L136,83.79V68.21l29.09-20A88.58,88.58,0,0,1,193.86,69.7ZM146.07,41.87,128,54.29,109.93,41.87a88.24,88.24,0,0,1,36.14,0ZM90.91,48.21l29.09,20V83.79L86.72,106.67l-15.07-4.89L62.14,69.7A88.58,88.58,0,0,1,90.91,48.21ZM63.15,187.42H83.52l7.17,20.27A88.4,88.4,0,0,1,63.15,187.42ZM110,214.13,98.12,180.71,107.35,168h41.3l9.23,12.71-11.83,33.42a88,88,0,0,1-36.1,0Zm55.36-6.44,7.17-20.27h20.37A88.4,88.4,0,0,1,165.31,207.69Z"
                      ></path>
                    </svg>
                  </div>
                  <h2 class="text-[#111518] text-base font-bold leading-tight">Yoga Instruction</h2>
                </div>
                <div class="flex flex-1 gap-3 rounded-lg border border-[#dbe1e6] bg-white p-4 flex-col">
                  <div class="text-[#111518]" data-icon="Translate" data-size="24px" data-weight="regular">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" fill="currentColor" viewBox="0 0 256 256">
                      <path
                        d="M239.15,212.42l-56-112a8,8,0,0,0-14.31,0l-21.71,43.43A88,88,0,0,1,100,126.93,103.65,103.65,0,0,0,127.69,64H152a8,8,0,0,0,0-16H96V32a8,8,0,0,0-16,0V48H24a8,8,0,0,0,0,16h87.63A87.76,87.76,0,0,1,88,116.35a87.74,87.74,0,0,1-19-31,8,8,0,1,0-15.08,5.34A103.63,103.63,0,0,0,76,127a87.55,87.55,0,0,1-52,17,8,8,0,0,0,0,16,103.46,103.46,0,0,0,64-22.08,104.18,104.18,0,0,0,51.44,21.31l-26.6,53.19a8,8,0,0,0,14.31,7.16L140.94,192h70.11l13.79,27.58A8,8,0,0,0,232,224a8,8,0,0,0,7.15-11.58ZM148.94,176,176,121.89,203.05,176Z"
                      ></path>
                    </svg>
                  </div>
                  <h2 class="text-[#111518] text-base font-bold leading-tight">Weather Forecasting</h2>
                </div>
                <div class="flex flex-1 gap-3 rounded-lg border border-[#dbe1e6] bg-white p-4 flex-col">
                  <div class="text-[#111518]" data-icon="Plant" data-size="24px" data-weight="regular">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" fill="currentColor" viewBox="0 0 256 256">
                      <path
                        d="M247.63,39.89a8,8,0,0,0-7.52-7.52c-51.76-3-93.32,12.74-111.18,42.22-11.8,19.49-11.78,43.16-.16,65.74a71.34,71.34,0,0,0-14.17,27L98.33,151c7.82-16.33,7.52-33.35-1-47.49-13.2-21.79-43.67-33.47-81.5-31.25a8,8,0,0,0-7.52,7.52c-2.23,37.83,9.46,68.3,31.25,81.5A45.82,45.82,0,0,0,63.44,168,54.58,54.58,0,0,0,87,162.33l25,25V216a8,8,0,0,0,16,0V186.51a55.61,55.61,0,0,1,12.27-35,73.91,73.91,0,0,0,33.31,8.4,60.9,60.9,0,0,0,31.83-8.86C234.89,133.21,250.67,91.65,247.63,39.89ZM47.81,147.6C32.47,138.31,23.79,116.32,24,88c28.32-.24,50.31,8.47,59.6,23.81,4.85,8,5.64,17.33,2.46,26.94L61.65,114.34a8,8,0,0,0-11.31,11.31l24.41,24.41C65.14,153.24,55.82,152.45,47.81,147.6Zm149.31-10.22c-13.4,8.11-29.15,8.73-45.15,2l53.69-53.7a8,8,0,0,0-11.31-11.31L140.65,128c-6.76-16-6.15-31.76,2-45.15,13.94-23,47-35.82,89.33-34.83C232.94,90.34,220.14,123.44,197.12,137.38Z"
                      ></path>
                    </svg>
                  </div>
                  <h2 class="text-[#111518] text-base font-bold leading-tight">Wine Tasting</h2>
                </div>
                <div class="flex flex-1 gap-3 rounded-lg border border-[#dbe1e6] bg-white p-4 flex-col">
                  <div class="text-[#111518]" data-icon="Sun" data-size="24px" data-weight="regular">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" fill="currentColor" viewBox="0 0 256 256">
                      <path
                        d="M120,40V16a8,8,0,0,1,16,0V40a8,8,0,0,1-16,0Zm72,88a64,64,0,1,1-64-64A64.07,64.07,0,0,1,192,128Zm-16,0a48,48,0,1,0-48,48A48.05,48.05,0,0,0,176,128ZM58.34,69.66A8,8,0,0,0,69.66,58.34l-16-16A8,8,0,0,0,42.34,53.66Zm0,116.68-16,16a8,8,0,0,0,11.32,11.32l16-16a8,8,0,0,0-11.32-11.32ZM192,72a8,8,0,0,0,5.66-2.34l16-16a8,8,0,0,0-11.32-11.32l-16,16A8,8,0,0,0,192,72Zm5.66,114.34a8,8,0,0,0-11.32,11.32l16,16a8,8,0,0,0,11.32-11.32ZM48,128a8,8,0,0,0-8-8H16a8,8,0,0,0,0,16H40A8,8,0,0,0,48,128Zm80,80a8,8,0,0,0-8,8v24a8,8,0,0,0,16,0V216A8,8,0,0,0,128,208Zm112-88H216a8,8,0,0,0,0,16h24a8,8,0,0,0,0-16Z"
                      ></path>
                    </svg>
                  </div>
                  <h2 class="text-[#111518] text-base font-bold leading-tight">Sustainable Agriculture</h2>
                </div>
                <div class="flex flex-1 gap-3 rounded-lg border border-[#dbe1e6] bg-white p-4 flex-col">
                  <div class="text-[#111518]" data-icon="Binoculars" data-size="24px" data-weight="regular">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" fill="currentColor" viewBox="0 0 256 256">
                      <path
                        d="M237.2,151.87v0a47.1,47.1,0,0,0-2.35-5.45L193.26,51.8a7.82,7.82,0,0,0-1.66-2.44,32,32,0,0,0-45.26,0A8,8,0,0,0,144,55V80H112V55a8,8,0,0,0-2.34-5.66,32,32,0,0,0-45.26,0,7.82,7.82,0,0,0-1.66,2.44L21.15,146.4a47.1,47.1,0,0,0-2.35,5.45v0A48,48,0,1,0,112,168V96h32v72a48,48,0,1,0,93.2-16.13ZM76.71,59.75a16,16,0,0,1,19.29-1v73.51a47.9,47.9,0,0,0-46.79-9.92ZM64,200a32,32,0,1,1,32-32A32,32,0,0,1,64,200ZM160,58.74a16,16,0,0,1,19.29,1l27.5,62.58A47.9,47.9,0,0,0,160,132.25ZM192,200a32,32,0,1,1,32-32A32,32,0,0,1,192,200Z"
                      ></path>
                    </svg>
                  </div>
                  <h2 class="text-[#111518] text-base font-bold leading-tight">Solar Energy</h2>
                </div>
                <div class="flex flex-1 gap-3 rounded-lg border border-[#dbe1e6] bg-white p-4 flex-col">
                  <div class="text-[#111518]" data-icon="Truck" data-size="24px" data-weight="regular">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" fill="currentColor" viewBox="0 0 256 256">
                      <path
                        d="M247.42,117l-14-35A15.93,15.93,0,0,0,218.58,72H184V64a8,8,0,0,0-8-8H24A16,16,0,0,0,8,72V184a16,16,0,0,0,16,16H41a32,32,0,0,0,62,0h50a32,32,0,0,0,62,0h17a16,16,0,0,0,16-16V120A7.94,7.94,0,0,0,247.42,117ZM184,88h34.58l9.6,24H184ZM24,72H168v64H24ZM72,208a16,16,0,1,1,16-16A16,16,0,0,1,72,208Zm81-24H103a32,32,0,0,0-62,0H24V152H168v12.31A32.11,32.11,0,0,0,153,184Zm31,24a16,16,0,1,1,16-16A16,16,0,0,1,184,208Zm48-24H215a32.06,32.06,0,0,0-31-24V128h48Z"
                      ></path>
                    </svg>
                  </div>
                  <h2 class="text-[#111518] text-base font-bold leading-tight">Travel Journalism</h2>
                </div>
                <div class="flex flex-1 gap-3 rounded-lg border border-[#dbe1e6] bg-white p-4 flex-col">
                  <div class="text-[#111518]" data-icon="Umbrella" data-size="24px" data-weight="regular">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" fill="currentColor" viewBox="0 0 256 256">
                      <path
                        d="M240,126.63A112.44,112.44,0,0,0,51.75,53.75a111.56,111.56,0,0,0-35.7,72.88A16,16,0,0,0,32,144h88v56a32,32,0,0,0,64,0,8,8,0,0,0-16,0,16,16,0,0,1-32,0V144h88a16,16,0,0,0,16-17.37ZM32,128l0,0a96.15,96.15,0,0,1,76.2-85.89C96.48,58,81.85,86.11,80.17,128Zm64.15,0c1.39-30.77,10.53-52.81,18.3-66.24A106.44,106.44,0,0,1,128,43.16a106.31,106.31,0,0,1,13.52,18.6C154.8,84.7,159,109.28,159.82,128Zm79.65,0c-1.68-41.89-16.31-70-28-85.94A96.07,96.07,0,0,1,224,128Z"
                      ></path>
                    </svg>
                  </div>
                  <h2 class="text-[#111518] text-base font-bold leading-tight">Wildlife Conservation</h2>
                </div>
                <div class="flex flex-1 gap-3 rounded-lg border border-[#dbe1e6] bg-white p-4 flex-col">
                  <div class="text-[#111518]" data-icon="Wallet" data-size="24px" data-weight="regular">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" fill="currentColor" viewBox="0 0 256 256">
                      <path
                        d="M216,72H56a8,8,0,0,1,0-16H192a8,8,0,0,0,0-16H56A24,24,0,0,0,32,64V192a24,24,0,0,0,24,24H216a16,16,0,0,0,16-16V88A16,16,0,0,0,216,72Zm0,128H56a8,8,0,0,1-8-8V86.63A23.84,23.84,0,0,0,56,88H216Zm-48-60a12,12,0,1,1,12,12A12,12,0,0,1,168,140Z"
                      ></path>
                    </svg>
                  </div>
                  <h2 class="text-[#111518] text-base font-bold leading-tight">Financial Planning</h2>
                </div>
                <div class="flex flex-1 gap-3 rounded-lg border border-[#dbe1e6] bg-white p-4 flex-col">
                  <div class="text-[#111518]" data-icon="Wind" data-size="24px" data-weight="regular">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" fill="currentColor" viewBox="0 0 256 256">
                      <path
                        d="M184,184a32,32,0,0,1-32,32c-13.7,0-26.95-8.93-31.5-21.22a8,8,0,0,1,15-5.56C137.74,195.27,145,200,152,200a16,16,0,0,0,0-32H40a8,8,0,0,1,0-16H152A32,32,0,0,1,184,184Zm-64-80a32,32,0,0,0,0-64c-13.7,0-26.95,8.93-31.5,21.22a8,8,0,0,0,15,5.56C105.74,60.73,113,56,120,56a16,16,0,0,1,0,32H24a8,8,0,0,0,0,16Zm88-32c-13.7,0-26.95,8.93-31.5,21.22a8,8,0,0,0,15,5.56C193.74,92.73,201,88,208,88a16,16,0,0,1,0,32H32a8,8,0,0,0,0,16H208a32,32,0,0,0,0-64Z"
                      ></path>
                    </svg>
                  </div>
                  <h2 class="text-[#111518] text-base font-bold leading-tight">Kite Surfing</h2>
                </div>
                <div class="flex flex-1 gap-3 rounded-lg border border-[#dbe1e6] bg-white p-4 flex-col">
                  <div class="text-[#111518]" data-icon="Wine" data-size="24px" data-weight="regular">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" fill="currentColor" viewBox="0 0 256 256">
                      <path
                        d="M205.33,95.67,183.56,21.74A8,8,0,0,0,175.89,16H80.11a8,8,0,0,0-7.67,5.74L50.67,95.67a63.46,63.46,0,0,0,17.42,64.67A87.39,87.39,0,0,0,120,183.63V224H88a8,8,0,1,0,0,16h80a8,8,0,1,0,0-16H136V183.63a87.41,87.41,0,0,0,51.91-23.29A63.46,63.46,0,0,0,205.33,95.67ZM86.09,32h83.82L190,100.19c.09.3.17.6.25.9-21.42,7.68-45.54-1.6-58.63-8.23C106.43,80.11,86.43,78.49,71.68,80.93ZM177,148.65a71.69,71.69,0,0,1-98,0,47.55,47.55,0,0,1-13-48.46l.45-1.52c12-4.06,31.07-5.14,57.93,8.47,11.15,5.65,29.16,12.85,48.43,12.85a68.64,68.64,0,0,0,19.05-2.6A47.2,47.2,0,0,1,177,148.65Z"
                      ></path>
                    </svg>
                  </div>
                  <h2 class="text-[#111518] text-base font-bold leading-tight">Astrology</h2>
                </div>
                <div class="flex flex-1 gap-3 rounded-lg border border-[#dbe1e6] bg-white p-4 flex-col">
                  <div class="text-[#111518]" data-icon="CirclesThree" data-size="24px" data-weight="regular">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" fill="currentColor" viewBox="0 0 256 256">
                      <path
                        d="M172,76a44,44,0,1,0-44,44A44.05,44.05,0,0,0,172,76Zm-44,28a28,28,0,1,1,28-28A28,28,0,0,1,128,104Zm60,24a44,44,0,1,0,44,44A44.05,44.05,0,0,0,188,128Zm0,72a28,28,0,1,1,28-28A28,28,0,0,1,188,200ZM68,128a44,44,0,1,0,44,44A44.05,44.05,0,0,0,68,128Zm0,72a28,28,0,1,1,28-28A28,28,0,0,1,68,200Z"
                      ></path>
                    </svg>
                  </div>
                  <h2 class="text-[#111518] text-base font-bold leading-tight">Esperanto</h2>
                </div>
              </div>
            </div>
                    
        </div>
      </div>
    </div>
  </body>
</html>
