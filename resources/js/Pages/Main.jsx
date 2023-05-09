import React , {useState} from 'react'
import Application from './Components/Application';
import Info from './Components/Info';
import Project from './Components/Project';
import Fade from '@mui/material/Fade';


export default function Main({projects , info}) {
  const [main, setMain] = useState(true)
  const [open, setOpen] = useState(false)
  const [projectId, setProjectId] = useState(0)

  const viewProject = () => {
    return e => {
      setProjectId(e);
      setMain(false)
      setTimeout(() => {
        setOpen(true)
      }, 500);
    }
  }
  
  const closeProject = () => {
    return () => {
      setOpen(false)
      setTimeout(() => {
        setMain(true)
      }, 500);
    }
  }

  return (
    <main className='text-slate-800 dark:text-slate-200 flex gap-4'>
        <div className={`flex flex-col lg:flex-row justify-between absolute left-0 w-full transition-all duration-500 ${main ? '' : 'left-[-100vw]'}`}>
            <Info info={info}/>
            <Fade in={main}>
              <div className='lg:absolute lg:right-0 lg:max-w-[45vw] xl:max-w-[55vw] p-8 lg:px-20 lg:py-14'>
                <h1 className='text-lg font-bold'>Projects</h1>
                <div className='grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-1 xl:grid-cols-2 gap-4 mt-4 group transition-opacity duration-500'>
                  {projects.map(app => (
                    <Application key={app.id} onLinkClick={viewProject()} application={app}/>
                  ))}
                </div>
              </div>
            </Fade>
        </div>
        <Project onBackLink={closeProject()} open={open} projectId={projectId}/>
    </main>
  )
}
