(function () {
    document.addEventListener("DOMContentLoaded", function () {
        var rail = document.querySelector("[data-team-rail]");
        var previousButton = document.querySelector("[data-team-prev]");
        var nextButton = document.querySelector("[data-team-next]");

        function getTeamScrollAmount() {
            var card = document.querySelector(".about-team-card");
            if (!card) {
                return 220;
            }

            var styles = window.getComputedStyle(document.querySelector(".about-team__track"));
            var gap = parseFloat(styles.columnGap || styles.gap || "0");

            return card.getBoundingClientRect().width + gap;
        }

        if (rail && previousButton && nextButton) {
            previousButton.addEventListener("click", function () {
                rail.scrollBy({
                    left: -getTeamScrollAmount(),
                    behavior: "smooth"
                });
            });

            nextButton.addEventListener("click", function () {
                rail.scrollBy({
                    left: getTeamScrollAmount(),
                    behavior: "smooth"
                });
            });
        }

        var showMoreButton = document.querySelector("[data-history-more]");

        if (showMoreButton) {
            showMoreButton.addEventListener("click", function () {
                var extraItems = document.querySelectorAll("[data-history-extra]");
                var isExpanded = showMoreButton.getAttribute("aria-expanded") === "true";
                var showMoreText = showMoreButton.getAttribute("data-show-more") || showMoreButton.textContent;
                var showLessText = showMoreButton.getAttribute("data-show-less") || showMoreText;

                extraItems.forEach(function (item) {
                    item.hidden = isExpanded;
                });

                showMoreButton.setAttribute("aria-expanded", String(!isExpanded));
                showMoreButton.textContent = isExpanded ? showMoreText : showLessText;
            });
        }
    });
})();
