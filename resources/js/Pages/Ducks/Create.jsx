import TextInput from "@/Components/TextInput";
import Duck from "@/Images/Duck";
import Authenticated from "@/Layouts/AuthenticatedLayout"
import { Head, useForm } from "@inertiajs/react"
import Hair1 from '@/Images/Hair/hair-1.svg'
import Hair2 from '@/Images/Hair/hair-2.svg'
import Hair3 from '@/Images/Hair/hair-3.svg'
import Acc1 from '@/Images/Acc/acc-1.svg'
import Acc2 from '@/Images/Acc/acc-2.svg'
import Acc3 from '@/Images/Acc/acc-3.svg'
import Shoes1 from '@/Images/Shoes/shoes-1.svg'
import Shoes2 from '@/Images/Shoes/shoes-2.svg'
import Shoes3 from '@/Images/Shoes/shoes-3.svg'

const IMAGE_MAP = {
    hair_1: Hair1,
    hair_2: Hair2,
    hair_3: Hair3,
    acc_1: Acc1,
    acc_2: Acc2,
    acc_3: Acc3,
    shoes_1: Shoes1,
    shoes_2: Shoes2,
    shoes_3: Shoes3,
}

export default () => {
    const {data, setData, errors, processing, post} = useForm({
        name: '',
        color: '#E1D3B8',
        hair: '',
        accessory: '',
        shoes: '',
        image: '',
    });

    const hairOptions = [
        {key: 'hair_1', image:IMAGE_MAP['hair_1']},
        {key: 'hair_2', image:IMAGE_MAP['hair_2']},
        {key: 'hair_3', image:IMAGE_MAP['hair_3']}
    ]
    const accOptions = [
        {key: 'acc_1', image:IMAGE_MAP['acc_1']},
        {key: 'acc_2', image:IMAGE_MAP['acc_2']},
        {key: 'acc_3', image:IMAGE_MAP['acc_3']}
    ]
    const shoeOptions = [
        {key: 'shoes_1', image:IMAGE_MAP['shoes_1']},
        {key: 'shoes_2', image:IMAGE_MAP['shoes_2']},
        {key: 'shoes_3', image:IMAGE_MAP['shoes_3']}
    ]

    const hair = data.hair ? IMAGE_MAP[data.hair] : null;
    const accessory = data.accessory ? IMAGE_MAP[data.accessory] : null;
    const shoes = data.shoes ? IMAGE_MAP[data.shoes] : null;

    const save = async ()=>{
        post(route('ducks.store'))
    }

    return (
        <Authenticated>
            <Head title="Build a Duck"/>
            <div className="flex flex-row w-full h-full ">
                <div className="flex-1 flex justify-center items-center ">
                    <div id="image-container" className="block w-[400px] h-[400px] relative bg-gray-100">
                        <div className="absolute left-0 top-0">
                            <Duck fill={data.color}/>
                        </div>
                        
                        {
                            hair && 
                                <div className="absolute left-0 top-0">
                                    <img src={hair} className="block w-[400px] h-[400px] min-w-[400px]"/>
                                </div>
                        }
                        {
                            accessory && 
                                <div className="absolute left-0 top-0">
                                    <img src={accessory} className="block w-[400px] h-[400px] min-w-[400px]"/>
                                </div>
                        }
                        {
                            shoes && 
                                <div className="absolute left-0 top-0">
                                    <img src={shoes} className="block w-[400px] h-[400px] min-w-[400px]"/>
                                </div>
                        }

                        
                    </div>
                </div>
                <div className="w-[250px] bg-slate-50 p-4 border-l flex flex-col gap-4">
                    <TextInput
                        placeholder="Name (Required)"
                        error={errors.name}
                        onChange={(e)=>setData('name', e.target.value)}
                        maxLength="20"
                        disabled={processing}
                    />
                    <Section title="Color">
                        <div className='overflow-clip rounded-full w-[40px] h-[40px] bg-green-600'>
                            <input 
                                disabled={processing}
                                type="color"
                                value={data.color}
                                onChange={(e)=>setData('color', e.target.value)}
                                className="border-0 ml-[-20px] mt-[-20px] w-[80px] h-[80px] p-0 m-0 outline-none rounded-2xl"
                            ></input>
                        </div>
                    </Section>
                    <Section title="Hair">
                        <div className="grid grid-cols-3 gap-2">
                            {hairOptions.map((o)=><ImageSelect disabled={processing} key={o.key} option={o} selected={data.hair === o.key} onSelect={(v)=>setData('hair', v)}/>)}
                        </div>
                    </Section>
                    <Section title="Accessories">
                        <div className="grid grid-cols-3 gap-2">
                            {accOptions.map((o)=><ImageSelect disabled={processing} key={o.key} option={o} selected={data.accessory === o.key} onSelect={(v)=>setData('accessory', v)}/>)}
                        </div>
                    </Section>
                    <Section title="Shoes">
                        <div className="grid grid-cols-3 gap-2">
                            {shoeOptions.map((o)=><ImageSelect disabled={processing} key={o.key} option={o} selected={data.shoes === o.key} onSelect={(v)=>setData('shoes', v)}/>)}
                        </div>
                    </Section>
                    <button onClick={save} className={`bg-blue-500 text-white rounded-md p-2 mt-2 text-sm font-bold disabled:opacity-40 disabled:cursor-not-allowed flex flex-row  gap-4 justify-center items-center`} disabled={!data.name || processing}>
                         {processing ? <Loader/> : 'Save'}
                    </button>
                    
                </div>
            </div>
        </Authenticated>
    );
}

const Section = ({title, children})=>{
    return <div>
        <h3 className="font-semibold border-b text-gray-600">{title}</h3>
        <div className="mt-2">
            {children}
        </div>
    </div>
}

const ImageSelect = ({option, selected, disabled, onSelect=()=>{}})=>{
    return (
        <div onClick={()=>!disabled && onSelect(selected ? '' : option.key)} className={`border-2 rounded-md p-2 cursor-pointer ${selected && 'border-blue-400'}`} >
            <img src={option.image}/>
        </div>
    )
}

const Loader = ()=>  <svg aria-hidden="true" className="w-5 h-5 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
    <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
</svg>
