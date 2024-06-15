import { Link, usePage } from '@inertiajs/react';

export default function Authenticated({ children }) {
    const page = usePage();

    const routes = [
        {label: 'Build a duck', route: 'ducks.create', icon: 'build', active: page.component.startsWith('Ducks/Create')},
        {label: 'My ducks', route: 'ducks.index', icon: 'manage_search', active: page.component.startsWith('Ducks/Index') || page.component.startsWith('Ducks/View') },
    ];
   
    return (
        <div className="min-h-screen w-full flex flex-row">
            <nav className='bg-gray-900 w-[200px] pt-20'>
                <ul className='flex flex-col  p-0 m-0'>
                    {routes.map((r) => <li className={`px-4 ${r.active ? 'bg-[rgba(255,255,255,0.15)] text-white' : ' text-[rgba(255,255,255,0.7)]'}`} key={r.label}>
                        <Link href={route(r.route)} className="flex flex-row justify-start items-center gap-2 py-2">
                            <span className="material-symbols-outlined">{r.icon}</span>
                            <span>{r.label}</span>
                        </Link>
                    </li>)}
                </ul>
            </nav>
            <section className='flex-1 flex flex-col'>
                <header className='block border-b w-full py-3 px-4'>
                    <h1 className='text-left text-xl font-bold'>Duck Builder 2.0</h1>
                </header>
                <main className='flex-1'>
                    {children}
                </main>
            </section>
        </div>
    );
}
