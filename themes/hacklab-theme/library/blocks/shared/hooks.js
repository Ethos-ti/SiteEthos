import { addQueryArgs } from '@wordpress/url';
import useSWR from 'swr';

import { EMPTY_OBJ } from './utils';

async function fetcher (url) {
    if (!url) {
        return undefined;
    }
    const isLocalRequest = url.startsWith(wpApiSettings.root);
    const res = await fetch(url, {
        headers: isLocalRequest ? { 'X-WP-Nonce': wpApiSettings.nonce } : undefined,
    });
    return res.json();
}

export function useRestApi (baseUrl, params = EMPTY_OBJ) {
    const url = baseUrl && addQueryArgs(new URL(baseUrl, wpApiSettings.root).toString(), params);
    const { data } = useSWR(url, fetcher, {
        dedupingInterval: 60 * 60,
    });
    return data;
}
