import React from 'react'

export default function Application({onLinkClick , application}) {
  const linkClick = () => {
    return e => {
      onLinkClick(e.target.id)
    }
  }

  return (
    <div className='bg-gray-200 dark:bg-gray-800 sm:even:translate-y-4 lg:even:translate-y-0 xl:even:translate-y-4 p-5 flex flex-col gap-3 lg:group-hover:opacity-40 lg:hover:!opacity-100 lg:hover:scale-[1.02] transition-all duration-200'>
      <h1 className='font-semibold'>{application.title}</h1>
      <div className='relative rounded-sm bg-cover aspect-video w-full bg-top bg-slate-200/80 bg-blend-lighten'
      style={{backgroundImage : `url(/storage/${application.image})`}}>
        <img className='max-w-[180px] min-w-[120px] absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2' src={`/storage/${application.logo}`} alt="logo" />
      </div>
      <div className='mb-2'>{application.short_description}</div>
      <a id={application.id} onClick={linkClick()} className='mt-auto w-fit quick-link' href="#">Learn More</a>
    </div>
  )
}
