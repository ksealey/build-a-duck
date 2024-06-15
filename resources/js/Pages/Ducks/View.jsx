import PrimaryButton from "@/Components/PrimaryButton"
import Authenticated from "@/Layouts/AuthenticatedLayout"
import { Head, router } from "@inertiajs/react"

export default ({duck}) => {
    return <Authenticated>
        <Head title="View a Duck"/>
        <div className="flex flex-col gap-8 items-center justify-center w-full h-full">
            <h2 className="text-4xl text-center font-bold">{duck.name}</h2>
            <img src={duck.image_uri} className="w-[200px] h-[200px]"></img>
            <div className="flex flex-row gap-2 justify-between">
                <DownloadButton href={route('ducks.download', {duckId: duck._id,format: 'png'})}>Download PNG</DownloadButton>
                <DownloadButton href={route('ducks.download', {duckId: duck._id,format: 'jpeg'})}>Download JPEG</DownloadButton>
            </div>
        </div>
    </Authenticated>
}

const DownloadButton = ({href, children}) => {
    return <a href={href} className="inline-block bg-blue-500 text-white text-xs font-bold rounded-lg py-2 px-4">{children}</a>
}