import PrimaryButton from '@/Components/PrimaryButton';
import TextInput from '@/Components/TextInput';
import { Link, Head, useForm } from '@inertiajs/react';

export default function Welcome() {
    const {data, setData, errors, setError, clearErrors, post}  = useForm({
        email: '',
        password: '',
    });

    const handleSubmit = (e)=>{
        e.preventDefault();

        // Do initial verification so we don't waste a request
        clearErrors();
        const _errors = {};
        if(!data.email){
            _errors.email = 'Email address required.';
        }else if(!/[A-z0-9\.\-\+\_]+\@[A-z0-9\.\-]+\.[A-z]{2,}/.test(data.email)){
            _errors.email = 'Email address invalid.';
        }

        if(!data.password){
            _errors.password = 'Password required.';
        }else if(data.password.length < 8){
            _errors.password = 'Password invalid.';
        }

        if(Object.keys(_errors).length){
            return setError(_errors);
        }

        post(route('login'));
    }

    return (
        <>
            <Head title="Build a Duck" />
            <div className='bg-blue-100 h-screen w-screen flex flex-col gap-4 justify-center items-center'>
                <h3 className='text-lg text-center'>Have you ever had dreams of building your own duck?<br/>Me neither. Anyways, log in to build a duck.</h3>
                <form onSubmit={handleSubmit} className='w-2/3 md:w-1/3 flex flex-col gap-4 rounded-md border bg-white px-6 py-8'> 
                    <TextInput
                        placeholder="Email address"
                        value={data.email}
                        error={errors.email}
                        onChange={(e)=> setData('email', e.target.value)}
                    ></TextInput>
                    <TextInput
                        placeholder="Password"
                        value={data.password}
                        error={errors.password}
                        onChange={(e)=> setData('password', e.target.value)}
                        type="password"
                    ></TextInput>
                    <div className='flex flex-row justify-center'>
                        <PrimaryButton>
                            Log In
                        </PrimaryButton>
                    </div>
                </form>
            </div>
        </>
    );
}
