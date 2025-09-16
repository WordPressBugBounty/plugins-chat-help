/**
 * Table of contents
 * -----------------------------------
 * 01.CURRENT TIME
 * 02.OPEN BUTTON
 * 03.CHECK TERMS AND CONDITION
 * 04.CHECK AVAILABILITY
 * 05.GET WEEK DAY
 * 06.MULTI USER AVAILABILITY
 * 07.MULTI USER SEARCH
 * 08.BUTTONS AVAILABILITY
 * 09.SINGLE CHAT AVAILABILITY
 * 10.ADD SUBJECT OR BODY TEXT
 * 11. SHOW HIDE AUTO OPEN POPUP AFTER SECONDS
 * DARK VERSION
 * -----------------------------------
 */

"use strict";
const wHelp = document.querySelectorAll(".wHelp");
const wHelpMulti = document.querySelectorAll(".wHelp-multi");
const wHelpButton = document.querySelector(".wHelp_button");
const wHelpBubble = document.querySelectorAll(".wHelp-bubble");
const wHelpCurrentTime = document.querySelector(".current-time");
const wHelpUserAvailability = document.querySelectorAll(
  ".wHelpUserAvailability"
);
const wHelpMultiPopupContent = document.querySelector(
  ".wHelp-multi__popup__content"
);
const wHelpCheckboxDiv = document.querySelectorAll(".wHelp--checkbox");
const wHelpCheckbox = document.querySelectorAll(".wHelp__checkbox");
const wHelpCheckButton = document.querySelectorAll(".wHelp__send-message");
const wHelpPopupContent = document.querySelectorAll(".wHelp__popup__content");
const wHelpButtons = document.querySelectorAll(".wHelpButtons");
const wHelpChatAvailability = document.querySelector(".chat-availability");

let analytics_parameter =
  whatshelp_frontend_script.analytics_parameter.google_analytics_parameter;
let event_name = whatshelp_frontend_script.analytics_parameter.event_name;

document.addEventListener("DOMContentLoaded", function () {
  document.querySelectorAll(".chat_help_analytics").forEach((btn) => {
    btn.addEventListener("click", function () {
      let number = this.getAttribute("data-number") || "";
      let group = this.getAttribute("data-group") || "";

      // Deep clone the analytics_parameter to avoid overwriting original
      let eventData = JSON.parse(JSON.stringify(analytics_parameter));

      eventData.forEach((param) => {
        if (param.event_parameter === "number") {
          param.event_parameter_value = number;
        } else if (param.event_parameter === "group") {
          param.event_parameter_value = group;
        }
      });

      // Build GA params object
      let ga_prams = {};
      eventData.forEach((param) => {
        ga_prams[param.event_parameter] = param.event_parameter_value;
      });


      // Send GA event
      if (typeof gtag !== "undefined") {
        gtag("event", event_name, ga_prams);
      }
    });
  });
});

// Configuration from external script
const { autoShowPopup, autoOpenPopupTimeout } = whatshelp_frontend_script;

/******************** 01. CURRENT TIME ********************/
if (wHelpCurrentTime) {
  const today = new Date();
  wHelpCurrentTime.innerText = `${today.getHours()}:${today.getMinutes()}:${today.getSeconds()}`;
}

/******************** 02. OPEN BUTTON ********************/
const toggleChatBtn = () => {
  [...wHelp, ...wHelpMulti].forEach((item) =>
    item.classList.toggle("wHelp-show")
  );
};
wHelpBubble.forEach((item) => {
  if (!wHelpButton) {
    item.addEventListener("click", toggleChatBtn);
  }
});

if (alternativeWHelpBubble.length > 0) {
  const elements = document.querySelectorAll(alternativeWHelpBubble);
  elements.forEach((item) => {
    if (!wHelpButton) {
      item.addEventListener("click", toggleChatBtn);
    }
  });
}

/******************** 03. CHECK TERMS AND CONDITION ********************/
const initCheckboxState = () => {
  const checkboxValue = localStorage.getItem("wHelpCheckboxValue") === "true";
  if (checkboxValue) {
    wHelpCheckButton.forEach((btn) =>
      btn.classList.remove("condition__checked")
    );
    wHelpCheckboxDiv.forEach((div) => (div.style.display = "none"));
  }
};

wHelpCheckbox.forEach((checkbox) => {
  checkbox.addEventListener("change", function () {
    if (this.checked) {
      localStorage.setItem("wHelpCheckboxValue", true);
      initCheckboxState();
    }
  });
});

initCheckboxState(); // Initialize checkbox state on load

/******************** 04. CHECK AVAILABILITY ********************/
function isAvailable(available, now) {
  let isAvailable = false;
  let almost_available = false;
  for (let key in available) {
    if (available.hasOwnProperty(key)) {
      if (get_day_of_week(key) == now.day()) {
        let timeRange = available[key].split("-");
        let start = moment.tz(timeRange[0], "HH:mm", now.tz()); // Apply the same timezone
        let end = moment.tz(timeRange[1], "HH:mm", now.tz());

        // Align start/end to the same date as `now`
        start.year(now.year()).month(now.month()).date(now.date());
        end.year(now.year()).month(now.month()).date(now.date());

        if (now.isBetween(start, end)) {
          isAvailable = true;
        } else if (now.isBefore(start)) {
          almost_available = true;
        }
      }
    }
  }
  return { isAvailable, almost_available };
}

/******************** 05.GET WEEK DAY  ********************/
function get_day_of_week(name) {
  name = name.toLowerCase();
  if (name == "sunday") {
    return 0;
  } else if (name == "monday") {
    return 1;
  } else if (name == "tuesday") {
    return 2;
  } else if (name == "wednesday") {
    return 3;
  } else if (name == "thursday") {
    return 4;
  } else if (name == "friday") {
    return 5;
  } else if (name == "saturday") {
    return 6;
  }
}

/******************** 06. MULTI USER AVAILABILITY ********************/
const handleUserAvailability = () => {
  const wHelpSearchInfo =
    wHelpMultiPopupContent?.getAttribute("data-search") === "true";
  const isGrid = document
    .querySelector(".wHelp-multi")
    ?.classList.contains("wHelp-grid");

  if (wHelpUserAvailability.length) {
    if (wHelpSearchInfo) wHelpMultiPopupContent.classList.add("wHelp-search");
    if (wHelpUserAvailability.length > (isGrid ? 4 : 3))
      wHelpMultiPopupContent.classList.add("wHelp-scroll");

    wHelpUserAvailability.forEach((item) => {
      const availableTimes = JSON.parse(
        item.getAttribute("data-userAvailability")
      );
      const timezone = item.getAttribute("data-timezone");
      const now = timezone ? moment().tz(timezone) : moment();

      const availability = isAvailable(availableTimes, now);

      if (availability.isAvailable || availableTimes == null) {
        item.classList.add("avatar-active");
        item.classList.remove("avatar-inactive");
      } else {
        item.classList.add("avatar-inactive");
        item.classList.remove("avatar-active");
        item.setAttribute("disabled", true);
      }
    });
  }
};
handleUserAvailability();

/******************** 07. MULTI USER SEARCH ********************/
function searchUser() {
  const input = document.getElementById("search-input").value.toUpperCase();
  const users = document
    .getElementById("multi-user")
    .getElementsByClassName("user");

  Array.from(users).forEach((user) => {
    const name = user
      .querySelector(".user__info--name")
      .textContent.toUpperCase();
    user.style.display = name.includes(input) ? "" : "none";
  });
}

/******************** 08. BUTTONS AVAILABILITY ********************/
const updateButtonAvailability = () => {
  wHelpButtons.forEach((item) => {
    const availableTimes = JSON.parse(item.getAttribute("data-btnavailablety"));
    const timezone = item.getAttribute("data-timezone");
    const now = timezone ? moment().tz(timezone) : moment();
    const availability = isAvailable(availableTimes, now);
    if (availability.isAvailable) {
      item.classList.add("avatar-active");
      item.classList.add("chat_help_analytics");
      item.classList.remove("avatar-inactive");
    } else {
      item.classList.add("avatar-inactive");
      item.classList.remove("avatar-active");
      item.classList.remove("chat_help_analytics");
    }
  });
};
updateButtonAvailability();

/******************** 09. SINGLE CHAT AVAILABILITY ********************/
if (wHelpChatAvailability) {
  const chatAvailableTime = JSON.parse(
    wHelpChatAvailability.getAttribute("data-availability")
  );
  const timezone = wHelpChatAvailability.getAttribute("data-timezone");

  const now = timezone ? moment().tz(timezone) : moment();
  const availability = isAvailable(chatAvailableTime, now);

  if (availability.isAvailable) {
    wHelpChatAvailability.classList.add("avatar-active");
    wHelpChatAvailability.classList.add("chat_help_analytics");
    wHelpChatAvailability.classList.remove("avatar-inactive");
    wHelpCheckButton.forEach((whatsappForm) => {
      whatsappForm.classList.add("chat_help_analytics");
      wHelpChatAvailability.classList.remove("chat_help_analytics");
    });
  } else {
    wHelpCheckButton.forEach((whatsappForm) => {
      whatsappForm.classList.remove("chat_help_analytics");
      wHelpChatAvailability.classList.add("chat_help_analytics");
    });
    wHelpChatAvailability.classList.add("avatar-inactive");
    wHelpChatAvailability.classList.remove("avatar-active");
    wHelpChatAvailability.classList.remove("chat_help_analytics");
  }
}

/******************** 10. ADD SUBJECT OR BODY TEXT ********************/
(function ($) {
  if ($("#form").length) {
    $("#form").validate();
  }

  wHelpPopupContent.forEach((whatsappForm) => {
    let submit_btn = whatsappForm.querySelector(".wHelp__send-message");
    $(whatsappForm).submit(function (e) {
      e.preventDefault();

      const form = $(this);
      if (!form.valid()) {
        return;
      }

      function getBrowserName() {
        const userAgent = navigator.userAgent;

        if (userAgent.indexOf("Firefox") > -1) {
          return "Firefox";
        } else if (userAgent.indexOf("SamsungBrowser") > -1) {
          return "Samsung Internet";
        } else if (
          userAgent.indexOf("Opera") > -1 ||
          userAgent.indexOf("OPR") > -1
        ) {
          return "Opera";
        } else if (userAgent.indexOf("Edg") > -1) {
          return "Edge";
        } else if (userAgent.indexOf("Chrome") > -1) {
          return "Chrome";
        } else if (userAgent.indexOf("Safari") > -1) {
          return "Safari";
        } else {
          return "Unknown";
        }
      }

      let userData = {
        device: /Mobi|Android/i.test(navigator.userAgent)
          ? "Mobile"
          : "Desktop",
        browser: getBrowserName(), // function from earlier
        platform: navigator.platform,
        screen: screen.width + "x" + screen.height,
        language: navigator.language,
        vendor: navigator.vendor,
        url: window.location.href,
        referrer: document.referrer,
      };

      const chatHelpUserInfo = localStorage.getItem("chat_help_user_information");
      const ipInfo = chatHelpUserInfo ? JSON.parse(chatHelpUserInfo) : {};
      const userInfo = { ...userData, ...ipInfo };

      wHelpCheckButton.forEach((btn) => {
        if (!btn.classList.contains("condition__checked")) {
          const chatAvailableTime = JSON.parse(
            wHelpChatAvailability?.getAttribute("data-availability")
          );
          if (chatAvailableTime) {
            const now = moment();
            const available = isAvailable(chatAvailableTime, now);
            if (available.isAvailable) {
              const formData = $(this).serialize();
              const currentUrl = window.location.href;
              const currentTitle = document.title;
              let button = whatsappForm.getAttribute("data-button");
              let loading = whatsappForm.getAttribute("data-loading");
              let productAttr = whatsappForm.getAttribute("data-product_attr");

              // Whatsapp form handler
              $.post(
                frontend_scripts.ajaxurl,
                {
                  action: "handle_form_submission",
                  data: formData,
                  userInfo,
                  product_id: productAttr,
                  nonce: frontend_scripts.nonce,
                  current_url: currentUrl,
                  current_title: currentTitle,
                },
                (response) => {
                  if (response.success) {
                    submit_btn.innerHTML = loading;
                    setTimeout(function () {
                      window.open(
                        response.data.whatsAppURL,
                        frontend_scripts.open_in_new_tab
                      );
                      form[0].reset();
                      submit_btn.innerHTML = button;
                    }, 100);
                  } else {
                    alert("Error processing request.");
                  }
                }
              ).fail(() => alert("Unexpected error occurred."));
            }
          }
        }
      });
    });
  });
})(jQuery);

/******************** 11. AUTO OPEN POPUP AFTER SECONDS ********************/
const autoShowPopupFunc = () => {
  if (autoShowPopup) toggleChatBtn();
};

if (autoOpenPopupTimeout > 0)
  setTimeout(autoShowPopupFunc, autoOpenPopupTimeout * 1000);
else autoShowPopupFunc();

document.addEventListener("DOMContentLoaded", function () {
  const urlParams = new URLSearchParams(window.location.search);
  const activeTab = urlParams.get("tab");

  if (activeTab) {
    document.querySelectorAll("#tab-menu a").forEach((tab) => {
      tab.classList.remove("active");
    });
    const targetTab = document.querySelector(`[data-id="${activeTab}-tab"]`);
    if (targetTab) {
      targetTab.classList.add("active");
      const section = document.querySelector(`#${activeTab}`);
      if (section) {
        section.scrollIntoView({ behavior: "smooth" });
      }
    }
  }
});


/******************** 12. USER INFORMATION ********************/
  async function userInformation() {
    const url = "https://ipwhois.app/json/";
    try {
      const response = await fetch(url);
      const result = await response.json();
      localStorage.setItem("chat_help_user_information", JSON.stringify(result));
    } catch (error) {
      console.error(error.message);
    }
  }
  userInformation();
