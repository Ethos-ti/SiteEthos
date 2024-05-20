export const EMPTY_ARR = [];

export const EMPTY_OBJ = Object.create(null);

export function sortByString (key) {
    return function (a, b) {
        return a[key].localeCompare(b[key]);
    };
}
