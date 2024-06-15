import Authenticated from "@/Layouts/AuthenticatedLayout"
import { Head, Link } from "@inertiajs/react"

export default ({ducks = []}) => {
    return <Authenticated>
        <Head title="My Ducks"/>
        {
            ducks.length ? <section className="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-4 p-4">
                {
                    ducks.map((duck)=><Link href={route('ducks.view', {duckId: duck._id})} key={duck._id} className="border-2 rounded-md flex flex-col items-center justify-center">
                        <span className="border-b font-semibold w-full max-w-full text-center overflow-elipsis overflow-hidden whitespace-nowrap">{duck.name}</span>
                        <img src={duck.image_uri} className="p-4 flex-1"/>
                    </Link>)
                }
            </section> : <div>No ducks here yet.</div>
        }
    </Authenticated>
}