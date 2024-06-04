import { __experimentalToggleGroupControl as ToggleGroupControl, __experimentalToggleGroupControlOptionIcon as ToggleGroupControlOptionIcon } from '@wordpress/components';
import { __, _x } from '@wordpress/i18n';

const DEFAULT_OPTIONS = ['small', 'medium', 'large'];

const OPTIONS_MAP = {
    'large': { label: _x('Large', 'size', 'hacklabr'), icon: LargeIcon },
    'medium': { label: _x('Medium', 'size', 'hacklabr'), icon: MediumIcon },
    'small': { label: _x('Small', 'size', 'hacklabr'), icon: SmallIcon },
    'x-large': { label: _x('Extra Large', 'size', 'hacklabr'), icon: ExtraLargeIcon },
    'x-small': { label: _x('Extra Small', 'size', 'hacklabr'), icon: ExtraSmallIcon },
};

function ExtraLargeIcon ({ size }) {
    // https://icon-sets.iconify.design/mdi/size-xl/
    return (
        <svg height={size} width={size} viewBox="0 0 24 24">
            <path fill="currentColor" d="M6 7h2l1 2.5L10 7h2l-2 5l2 5h-2l-1-2.5L8 17H6l2-5zm7 0h2v8h4v2h-6z"/>
        </svg>
    );
}

function ExtraSmallIcon ({ size }) {
    // https://icon-sets.iconify.design/mdi/size-xs/
    return (
        <svg height={size} width={size} viewBox="0 0 24 24">
            <path fill="currentColor" d="M6 7h2l1 2.5L10 7h2l-2 5l2 5h-2l-1-2.5L8 17H6l2-5zm9 0h4v2h-4v2h2a2 2 0 0 1 2 2v2c0 1.11-.89 2-2 2h-4v-2h4v-2h-2a2 2 0 0 1-2-2V9c0-1.1.9-2 2-2"/>
        </svg>
    );
}

function LargeIcon ({ size }) {
    // https://icon-sets.iconify.design/mdi/size-l/
    return (
        <svg height={size} width={size} viewBox="0 0 24 24">
            <path fill="currentColor" d="M9 7v10h6v-2h-4V7z"/>
        </svg>
    );
}

function MediumIcon ({ size }) {
    // https://icon-sets.iconify.design/mdi/size-m/
    return (
        <svg height={size} width={size} viewBox="0 0 24 24">
            <path fill="currentColor" d="M9 7c-1.1 0-2 .9-2 2v8h2V9h2v7h2V9h2v8h2V9a2 2 0 0 0-2-2z"/>
        </svg>
    );
}

function SmallIcon ({ size }) {
    // https://icon-sets.iconify.design/mdi/size-s/
    return (
        <svg height={size} width={size} viewBox="0 0 24 24">
            <path fill="currentColor" d="M11 7c-1.1 0-2 .9-2 2v2a2 2 0 0 0 2 2h2v2H9v2h4c1.11 0 2-.89 2-2v-2a2 2 0 0 0-2-2h-2V9h4V7z"/>
        </svg>
    );
}

export function SelectSize ({ label = __('Size', 'hacklabr'), options = DEFAULT_OPTIONS, value, onChange }) {
    return (
        <ToggleGroupControl isBlock={true} label={label} value={value} onChange={onChange}>
        {options?.map?.((option) => (
            <ToggleGroupControlOptionIcon
                icon={OPTIONS_MAP[option]?.icon}
                label={OPTIONS_MAP[option]?.label}
                value={option}
            />
        ))}
        </ToggleGroupControl>
    );
}
