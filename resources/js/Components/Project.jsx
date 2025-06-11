import React , {useState , useEffect} from 'react'
import Fade from '@mui/material/Fade';
import parse from 'html-react-parser';

export default function Project({open , onBackLink , projectId}) {
  const f = new Intl.ListFormat('en-us');

  const [project, setProject] = useState({});
  const [loading, setLoading] = useState(true);
  
  useEffect(() => {
    if (open) {
      setLoading(true);
      axios.post('/project',
      {id : projectId})
      .then(function(res){
        setProject(res.data);
        setTimeout(() => {
          setLoading(false);
        }, 100);
      })
      .catch(function(res) {
        console.error(res);
        setLoading(false);
        onBackLink();
      })
    }
  }, [open])
  

  const backLink = () => {
    return () => {
      onBackLink()
    }
  }
  return (
    <>
      <Fade in={open && loading} timeout={10}>
         <div className='absolute w-full h-full'>
          {/* <a onClick={backLink()} href="#" className='absolute left-8 top-8 md:left-20 md:top-10 z-5 app-link hover:bg-[#059669] p-3 rounded-full transition-all'>
              <img className='h-[20px] w-[20px] transition-all' src="/storage/back.svg" alt="" />
          </a>   */}
          <img className='h-32 absolute top-[50%] left-[50%] translate-x-[-50%] translate-y-[-50%]' src="/storage/puff.svg" alt="" />
        </div>
      </Fade>
      <Fade in={!loading && open} timeout={500}>
          <div className={`p-8 md:px-20 md:py-10 w-full flex flex-col gap-8`}>
            <div className='flex items-center justify-between'>
              <a onClick={backLink()} href="#" className='app-link relative hover:bg-[#059669] p-3 rounded-full transition-all'>
                  <img className='h-[20px] w-[20px] transition-all' src="/storage/back.svg" alt="" />
              </a>
              <span className='font-semibold text-2xl text-center'>{project.title}</span>
              <a href={project.url ?? '#'} target="_blank" className={`${project.url ? '' : 'pointer-events-none opacity-50'} app-link relative hover:bg-[#059669] p-3 rounded-full transition-all`}>
                  <img className='h-[20px] w-[20px] transition-all' src="/storage/visit.svg" alt="" />
              </a>
            </div>
            <div style={{backgroundImage: `url('/storage/${project.image_1 ?? project.image}')`}} className='flex flex-col p-6 justify-center items-center  bg-black/80 bg-blend-darken gap-8 object-top rounded-md bg-cover bg-center min-h-[calc(100dvh_-_152px)] md:min-h-[calc(100dvh_-_160px)]'>
              <div className='text-xl md:text-3xl max-w-[82%] md:max-w-[66%]'>
                {parse(project.description ?? '')}
                <div className='text-lg md:text-xl font-bold mt-8'>{f.format(project.technologies ?? [])}</div>
              </div>
            </div>
          </div>
      </Fade>
    </>
  )
}
