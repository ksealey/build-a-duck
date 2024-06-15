import { forwardRef, useEffect, useRef } from 'react';
import InputError from './InputError';

export default forwardRef(function TextInput({ type = 'text', className = '', error = '', isFocused = false, ...props }, ref) {
    const input = ref ? ref : useRef();

    useEffect(() => {
        if (isFocused) {
            input.current.focus();
        }
    }, []);

    return (
        <span className='flex flex-col ga-2'>
            <input
                {...props}
                className='bg-slate-200 px-2 py-3 rounded-md border-none'
                type={type}
                ref={input}
            />
            {error && <InputError message={error}></InputError>}
        </span>
    );
});
