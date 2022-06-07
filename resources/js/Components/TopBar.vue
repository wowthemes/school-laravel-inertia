<script setup>
</script>


<template>
  
    <nav aria-label="breadcrumb" class="-intro-x mr-auto hidden sm:flex">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Application</a></li>
        <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
      </ol>
    </nav>
    <div class="intro-x relative mr-3 sm:mr-6">
      <div class="search relative hidden sm:block">
        <input
          type="text"
          class="search__input form-control border-transparent"
          placeholder="Search..."
        /><svg
          xmlns="http://www.w3.org/2000/svg"
          width="24"
          height="24"
          viewBox="0 0 24 24"
          fill="none"
          stroke="currentColor"
          stroke-width="2"
          stroke-linecap="round"
          stroke-linejoin="round"
          class="lucide search__icon dark:text-slate-500"
        >
          <circle cx="11" cy="11" r="8"></circle>
          <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
        </svg>
      </div>
      <a class="notification sm:hidden" href=""
        ><svg
          xmlns="http://www.w3.org/2000/svg"
          width="24"
          height="24"
          viewBox="0 0 24 24"
          fill="none"
          stroke="currentColor"
          stroke-width="2"
          stroke-linecap="round"
          stroke-linejoin="round"
          class="lucide notification__icon dark:text-slate-500"
        >
          <circle cx="11" cy="11" r="8"></circle>
          <line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg
      ></a>
      <div class="search-result">
        
      </div>
    </div>
    <div
      class="dropdown intro-x mr-auto sm:mr-6"
      data-tw-placement="bottom-end"
    >
      <div
        class="dropdown-toggle notification notification--bullet cursor-pointer"
        aria-expanded="false"
        data-tw-toggle="dropdown"
        role="button"
      >
        <svg
          xmlns="http://www.w3.org/2000/svg"
          width="24"
          height="24"
          viewBox="0 0 24 24"
          fill="none"
          stroke="currentColor"
          stroke-width="2"
          stroke-linecap="round"
          stroke-linejoin="round"
          class="lucide notification__icon dark:text-slate-500"
        >
          <path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
          <path d="M13.73 21a2 2 0 01-3.46 0"></path>
        </svg>
      </div>
      <div class="dropdown-menu notification-content pt-2">
        
      </div>
    </div>
    <div class="dropdown intro-x w-8 h-8" data-tw-placement="bottom-end">
      <div
        class="
          dropdown-toggle
          w-8
          h-8
          rounded-full
          overflow-hidden
          shadow-lg
          image-fit
          zoom-in
        "
        aria-expanded="false"
        data-tw-toggle="dropdown"
        role="button"
      >
        <img
          alt="Midone Tailwind HTML Admin Template"
          src="/images/profile-4.jpg"
        />
      </div>
      <div class="dropdown-menu w-56" v-if="false">
        <ul class="dropdown-content bg-primary text-white">
          <li>
            <div class="dropdown-header !font-normal">
              <div class="font-medium">Johnny Depp</div>
              <div class="text-xs text-white/70 mt-0.5 dark:text-slate-500">
                Software Engineer
              </div>
            </div>
          </li>
          <li><hr class="dropdown-divider border-white/[0.08]" /></li>
          <li>
            <a class="dropdown-item cursor-pointer hover:bg-white/5"
              ><svg
                xmlns="http://www.w3.org/2000/svg"
                width="24"
                height="24"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
                class="lucide w-4 h-4 mr-2"
              >
                <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"></path>
                <circle cx="12" cy="7" r="4"></circle>
              </svg>
              Profile
            </a>
          </li>
          <li>
            <a class="dropdown-item cursor-pointer hover:bg-white/5"
              ><svg
                xmlns="http://www.w3.org/2000/svg"
                width="24"
                height="24"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
                class="lucide w-4 h-4 mr-2"
              >
                <path
                  d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"
                ></path>
                <path
                  d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"
                ></path>
              </svg>
              Add Account
            </a>
          </li>
          <li>
            <a class="dropdown-item cursor-pointer hover:bg-white/5"
              ><svg
                xmlns="http://www.w3.org/2000/svg"
                width="24"
                height="24"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
                class="lucide w-4 h-4 mr-2"
              >
                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                <path d="M7 11V7a5 5 0 0110 0v4"></path>
              </svg>
              Reset Password
            </a>
          </li>
          <li>
            <a class="dropdown-item cursor-pointer hover:bg-white/5"
              ><svg
                xmlns="http://www.w3.org/2000/svg"
                width="24"
                height="24"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
                class="lucide w-4 h-4 mr-2"
              >
                <circle cx="12" cy="12" r="10"></circle>
                <path d="M9.09 9a3 3 0 015.83 1c0 2-3 3-3 3"></path>
                <line x1="12" y1="17" x2="12.01" y2="17"></line>
              </svg>
              Help
            </a>
          </li>
          <li><hr class="dropdown-divider border-white/[0.08]" /></li>
          <li>
            <a class="dropdown-item cursor-pointer hover:bg-white/5"
              ><svg
                xmlns="http://www.w3.org/2000/svg"
                width="24"
                height="24"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
                class="lucide w-4 h-4 mr-2"
              >
                <rect x="1" y="5" width="22" height="14" rx="7" ry="7"></rect>
                <circle cx="16" cy="12" r="3"></circle>
              </svg>
              Logout
            </a>
          </li>
        </ul>
      </div>
    </div>
  
</template>