import { SelectControl } from '@wordpress/components';
import { __ } from '@wordpress/i18n';

const compareOptions = [
    { label: __('OR', 'hacklabr'), value: 'OR' },
    { label: __('AND', 'hacklabr'), value: 'AND' },
];

export function SelectCompare ({ label = __('Compare terms', 'hacklabr'), value, onChange }) {
    return (
        <SelectControl
            label={label}
            options={compareOptions}
            value={value}
            onChange={onChange}
        />
    )
}
