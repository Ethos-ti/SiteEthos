import apiFetch from '@wordpress/api-fetch';
import { addQueryArgs } from '@wordpress/url';
import useSWR from 'swr';

import { EMPTY_OBJ } from './utils';

function swrFetcher (url) {
    return apiFetch({ path: url });
}

export function useRestApi (baseUrl, params = EMPTY_OBJ) {
    const url = baseUrl && addQueryArgs(baseUrl, params);
    return useSWR(url, swrFetcher, {
        dedupingInterval: 5 * 60 * 1000,
    });
}
