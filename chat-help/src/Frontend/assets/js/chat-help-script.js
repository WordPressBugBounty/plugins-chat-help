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
const noBubble = document.querySelector(".no_bubble");
const wHelpBubble = document.querySelectorAll(".wHelp-bubble");
const wHelpCurrentTime = document.querySelector(".current-time");
const wHelpUserAvailability = document.querySelectorAll(
  ".wHelpUserAvailability",
);
const wHelpMultiPopupContent = document.querySelector(
  ".wHelp-multi__popup__content",
);
const wHelpCheckboxDiv = document.querySelectorAll(".wHelp--checkbox");
const wHelpCheckbox = document.querySelectorAll(".wHelp__checkbox");
const wHelpCheckButton = document.querySelectorAll(".wHelp__send-message");
const wHelpPopupContent = document.querySelectorAll(".wHelp__popup__content");
const wHelpButtons = document.querySelectorAll(".wHelpButtons");
const wHelpChatAvailability = document.querySelector(".chat-availability");
const subtitleEl = document.querySelector(".info__title");
let analytics_parameter =
  chat_help_script.analytics_parameter.google_analytics_parameter;
let event_name = chat_help_script.analytics_parameter.event_name;

document.addEventListener("DOMContentLoaded", function () {
  document.querySelectorAll(".chat_help_analytics").forEach((btn) => {
    btn.addEventListener("click", function () {
      let number = this.getAttribute("data-number") || "";
      let group = this.getAttribute("data-group") || "";

      // Deep clone the analytics_parameter to avoid overwriting original
      let eventData = JSON.parse(JSON.stringify(analytics_parameter));

      if (eventData) {
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
      }
    });
  });
});

// Configuration from external script
const { autoShowPopup, autoOpenPopupTimeout } = chat_help_script;

/******************** 01. CURRENT TIME ********************/
if (wHelpCurrentTime) {
  const today = new Date();
  wHelpCurrentTime.innerText = `${today.getHours()}:${today.getMinutes()}:${today.getSeconds()}`;
}

/******************** 02. OPEN BUTTON ********************/
const toggleChatBtn = () => {
  [...wHelp, ...wHelpMulti].forEach((item) =>
    item.classList.toggle("wHelp-show"),
  );
};
wHelpBubble.forEach((item) => {
  if (!noBubble) {
    item.addEventListener("click", toggleChatBtn);
  }
});

if (alternativeWHelpBubble.length > 0) {
  const elements = document.querySelectorAll(alternativeWHelpBubble);
  elements.forEach((item) => {
    if (!noBubble) {
      item.addEventListener("click", toggleChatBtn);
    }
  });
}

/******************** 03. CHECK TERMS AND CONDITION ********************/
const initCheckboxState = () => {
  const checkboxValue = localStorage.getItem("wHelpCheckboxValue") === "true";
  if (checkboxValue) {
    wHelpCheckButton.forEach((btn) =>
      btn.classList.remove("condition__checked"),
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
        item.getAttribute("data-userAvailability"),
      );
      let timezone = item.getAttribute("data-timezone");
      if (timezone == "" || timezone == null) {
        timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
      }
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
    const availableTimes = JSON.parse(item.getAttribute("data-availability"));
    let timezone = item.getAttribute("data-timezone");
    if (timezone == "" || timezone == null) {
      timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
    }
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
    wHelpChatAvailability.getAttribute("data-availability"),
  );

  let timezone = wHelpChatAvailability.getAttribute("data-timezone");
  if (timezone == "" || timezone == null) {
    timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
  }
  const now = timezone ? moment().tz(timezone) : moment();
  const availability = isAvailable(chatAvailableTime, now);

  if (!availability.isAvailable) {
    subtitleEl.textContent = subtitleEl.getAttribute("data-offline");
  } else {
    subtitleEl.textContent = subtitleEl.getAttribute("data-online");
  }

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
  /* ========================
     COMMON UTIL FUNCTIONS
  ======================== */
  function getBrowserName() {
    const ua = navigator.userAgent;
    if (ua.includes("Firefox")) return "Firefox";
    if (ua.includes("SamsungBrowser")) return "Samsung Internet";
    if (ua.includes("Opera") || ua.includes("OPR")) return "Opera";
    if (ua.includes("Edg")) return "Edge";
    if (ua.includes("Chrome")) return "Chrome";
    if (ua.includes("Safari")) return "Safari";
    return "Unknown";
  }

  function getUserData() {
    return {
      device: /Mobi|Android/i.test(navigator.userAgent) ? "Mobile" : "Desktop",
      browser: getBrowserName(),
      platform: navigator.platform,
      screen: screen.width + "x" + screen.height,
      language: navigator.language,
      vendor: navigator.vendor,
      url: window.location.href,
      referrer: document.referrer,
      ip: chat_help_frontend_scripts.ip,
    };
  }

  /* ========================
     FORM SUBMIT (GLOBAL)
  ======================== */
  $(document).on("submit", "form#wHelp_form", function (e) {
    e.preventDefault();
    const form = $(this);
    // ✅ correct validation check
    if (!form.valid()) return;

    const submit_btn = form.find(".wHelp__send-message");
    const number = submit_btn.data("number") || "";
    const group = submit_btn.data("group") || "";
    const formData = form.serialize();
    const userInfo = getUserData();
    const currentUrl = window.location.href;
    const currentTitle = document.title;
    let button = form.data("button");
    let loading = form.data("loading");
    let product_attr = form.data("product_attr");
    let agentName = $(document).find(".wHelp_bubble .info__name").text().trim();

    $.post(
      chat_help_frontend_scripts.ajaxurl,
      {
        action: "handle_form_submission",
        data: formData,
        userInfo,
        nonce: chat_help_frontend_scripts.nonce,
        product_id: product_attr,
        current_url: currentUrl,
        current_title: currentTitle,
        agentName: agentName,
      },
      (response) => {
        if (response.success) {
          submit_btn.innerHTML = loading;
          setTimeout(function () {
            window.open(
              response.data.whatsAppURL,
              chat_help_frontend_scripts.open_in_new_tab,
            );
            form[0].reset();
            submit_btn.innerHTML = button;
          }, 100);
        } else {
          alert("Error processing request.");
        }
      },
    ).fail(() => alert("Unexpected error occurred."));
  });
  $(document).on("submit", "form#agent_input", function (e) {
    e.preventDefault();
    const form = $(this);
    // ✅ correct validation check
    if (!form.valid()) return;

    const submit_btn = form.find(".send_agent_with_input");
    
    const number = submit_btn.data("number") || "";
    const group = submit_btn.data("group") || "";
    const formData = form.serialize();
    const userInfo = getUserData();
    const currentUrl = window.location.href;
    const currentTitle = document.title;
    let button = form.data("button");
    let loading = form.data("loading");
    let product_attr = form.data("product_attr");
    let agentName = $(document).find(".wHelp_bubble .info__name").text().trim();

    $.post(
      chat_help_frontend_scripts.ajaxurl,
      {
        action: "handle_form_submission",
        data: formData,
        userInfo,
        nonce: chat_help_frontend_scripts.nonce,
        product_id: product_attr,
        current_url: currentUrl,
        current_title: currentTitle,
        agentName: agentName,
      },
      (response) => {
        if (response.success) {
          submit_btn.innerHTML = loading;
          setTimeout(function () {
            window.open(
              response.data.whatsAppURL,
              chat_help_frontend_scripts.open_in_new_tab,
            );
            form[0].reset();
            submit_btn.innerHTML = button;
          }, 100);
        } else {
          alert("Error processing request.");
        }
      },
    ).fail(() => alert("Unexpected error occurred."));
  });

  /* ========================
     VALIDATION INIT (DYNAMIC)
  ======================== */
  $(document).on("focus", "form#wHelp_form,form#agent_input", function () {
    if (!$(this).data("validator")) {
      $(this).validate();
    }
  });
})(jQuery);

/******************** 11. AUTO OPEN POPUP AFTER SECONDS ********************/
const autoShowPopupFunc = () => {
  if (autoShowPopup === "1") toggleChatBtn();
};

if (autoOpenPopupTimeout > 0)
  setTimeout(autoShowPopupFunc, autoOpenPopupTimeout);
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
