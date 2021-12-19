import { useRouter } from 'next/router';
import { HTMLAttributes } from 'react';
import Link from './Link';

interface NavLinkProps {
    href: string
    exact?: boolean
    children?: JSX.Element | string
    className?: string,
};

const NavLink = ({ children, href, exact = false, ...props }: NavLinkProps & HTMLAttributes<HTMLLinkElement>) => {
    const { pathname } = useRouter();
    const isActive = exact ? pathname === href : pathname.startsWith(href);
    
    if (isActive) {
        props.className += ' active';
    }

    return <Link href={href} {...props}>{children}</Link>;
}

export default NavLink;