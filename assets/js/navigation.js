document.addEventListener("DOMContentLoaded", function () {
    // Make nav items clickable
    const navItems = document.querySelectorAll(".nav-item");
  
    navItems.forEach((item) => {
      item.addEventListener("click", function (e) {
        const link = this.getAttribute("href");
        if (link) {
          window.location.href = link;
        }
      });
    });
  
    // Add active class to current page
    const currentPage = window.location.pathname.split("/").pop();
    navItems.forEach((item) => {
      const itemHref = item.getAttribute("href");
      if (itemHref && itemHref.includes(currentPage)) {
        item.classList.add("active");
      }
    });
  });
  