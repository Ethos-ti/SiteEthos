export const EMPTY_ARR = [];

export const EMPTY_OBJ = Object.create(null);

export function loop (length, fn) {
    return Array.from({ length }).map((_, index) => fn(index));
}

export function sortByString (key) {
    return function (a, b) {
        return a[key].localeCompare(b[key]);
    };
}
