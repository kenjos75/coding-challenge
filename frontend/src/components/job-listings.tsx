

const JobListings = ({ items }) => {
    return (
    <div className="w-full flex-col">
        {
            items.map((i, key) => {
                return (
                    <div key={`listing-${key}`} className="mt-4 grid grid-cols-2 gap-6">
                        <div className="bg-white p-4 rounded-lg shadow-lg">
                            <h3 className="text-xl font-semibold mb-4">{i.title}</h3>
                            <p>
                                {i.description}
                            </p>
                            <p>
                                <a className="text-blue-600" href={i.url}>View job</a>
                            </p>
                        </div>
                    </div>
                )
            })
        }
    </div>)
}
export default JobListings;