document.addEventListener('alpine:init', () => {

    const isCurrentTab = ({ currentTab }, tab) => currentTab === tab;

    Alpine.bind('Tabs', ($data) => ({
        'x-id': () => ['tabs'],
        ':id': () => $data.$id('tabs'),
    }));

    Alpine.bind('TabButton', (tab, $data) => ({
        'role': 'tab',
        ':aria-controls': () => $data.$id('tabs', `panel-${tab}`),
        ':aria-selected': () => isCurrentTab($data, tab),
        ':class': () => ({
            'tab--active': isCurrentTab($data, tab),
        }),
        ':id': () => $data.$id('tabs', `button-${tab}`),
        ':tabindex': () => isCurrentTab($data, tab) ? 0 : -1,
        '@click': () => {
            $data.currentTab = tab;
        },
    }));

    Alpine.bind('TabPanel', (tab, $data) => ({
        'role': 'tabpanel',
        'tabindex': 0,
        ':aria-labeledby': () => $data.$id('tabs', `button-${tab}`),
        ':hidden': () => !isCurrentTab($data, tab),
        ':id': () => $data.$id('tabs', `panel-${tab}`),
    }));
});
