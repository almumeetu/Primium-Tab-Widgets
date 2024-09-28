document.addEventListener('DOMContentLoaded', function() {
    // Select all tabs navigation wrappers
    const tabNavigations = document.querySelectorAll('.tabs-navigation');

    tabNavigations.forEach(navigation => {
        const tabs = navigation.querySelectorAll('.tabs-navigation__item');
        const tabContents = navigation.closest('.features-tabs-container').querySelectorAll('.features-tabs__item');
        const runner = navigation.querySelector('.runner'); // Get the runner specific to this widget instance

        const activeColor = 'rgb(96, 13, 255)';

        function updateRunnerPosition(tab) {
            const tabHeight = tab.offsetHeight;
            const tabTopPosition = tab.offsetTop;

            runner.style.height = `${tabHeight}px`;
            runner.style.top = `${tabTopPosition}px`;
            runner.style.backgroundColor = activeColor;
        }

        tabs.forEach((tab) => {
            tab.addEventListener('click', () => {
                tabs.forEach(t => t.classList.remove('active'));
                tabContents.forEach(content => content.classList.remove('active'));

                tab.classList.add('active');
                const targetTabContent = Array.from(tabContents).find(content => content.getAttribute('data-tab') === tab.getAttribute('data-tab'));
                if (targetTabContent) {
                    targetTabContent.classList.add('active');
                }

                updateRunnerPosition(tab);
            });
        });

        // Initialize the runner position for the first tab
        updateRunnerPosition(tabs[0]);
    });
});
