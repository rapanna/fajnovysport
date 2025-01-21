<form class="search" role="search" action="<?php echo home_url('/'); ?>">
        <label class="search__label" for="search">Web search
          <p id="error" class="" role="alert"></p>
        </label>
        <input id="search" class="search__input" type="search" name="s" id="search" aria-label="Web search" value="<?php echo get_search_query(); ?>">
        <button id="searchBtn" class="search__btn" type="submit" aria-labelledby="Search">
          <svg xmlns="http://www.w3.org/2000/svg" width="22" height="25" viewBox="0 0 22 25" fill="none">
            <title id="search">Search</title>
            <g clip-path="url(#clip0_114_944)">
              <path d="M9.79843 19.5969C4.39469 19.5969 0 15.2022 0 9.79843C0 4.39469 4.39469 0 9.79843 0C15.2022 0 19.5969 4.39469 19.5969 9.79843C19.5969 15.2022 15.2022 19.5969 9.79843 19.5969ZM9.79843 1.3277C5.12493 1.3277 1.3277 5.12493 1.3277 9.79843C1.3277 14.4719 5.12493 18.2692 9.79843 18.2692C14.4719 18.2692 18.2692 14.4719 18.2692 9.79843C18.2692 5.12493 14.4719 1.3277 9.79843 1.3277Z" fill="#00345F"/>
              <path d="M21.6548 22.0133L16.3838 16.0652C15.8528 16.7556 15.1756 17.3531 14.3392 17.7646L19.6765 23.7791C19.9421 24.0712 20.3005 24.2305 20.6723 24.2305C20.991 24.2305 21.2963 24.1243 21.5486 23.8986C22.0929 23.4074 22.1461 22.5709 21.6548 22.0266V22.0133Z" fill="#00345F"/>
            </g>
            <defs>
              <clipPath id="clip0_114_944">
                <rect width="22" height="24.2173" fill="white"/>
              </clipPath>
            </defs>
          </svg>
        </button>
</form>