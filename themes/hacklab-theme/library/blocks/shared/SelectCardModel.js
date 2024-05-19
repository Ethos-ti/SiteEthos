import { SelectControl } from '@wordpress/components';
import { useMemo } from '@wordpress/element';
import { __, _x } from '@wordpress/i18n';

import { useRestApi } from './hooks';
import { EMPTY_ARR, sortByString } from './utils';

function getOptions (cardModels) {
    if (!cardModels) {
        return EMPTY_ARR;
    }

    return Object.values(cardModels.options)
        .map((cardModel) => ({
            label: cardModel.label,
            value: cardModel.slug,
        }))
        .sort(sortByString('label'));
}

export function SelectCardModel ({ label = __('Card model', 'hacklabr'), value, onChange }) {
    const { data: settings } = useRestApi('hacklabr/v2/block_settings');

    const options = useMemo(() => {
        const baseOptions = getOptions(settings?.cardModels);
        return [{ label: _x('Default model', 'card', 'hacklabr'), value: '' }, ...baseOptions];
    }, [settings]);

    return (
        <SelectControl
            label={label}
            options={options}
            value={value}
            onChange={onChange}
        />
    );
}
