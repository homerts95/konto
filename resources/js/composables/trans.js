import { usePage } from '@inertiajs/vue3';

export function useTrans( value )
{

    const array = usePage().props.translations;
console.log(usePage().props);
    return array[ value ] != null ? array[ value ] : value;
}
