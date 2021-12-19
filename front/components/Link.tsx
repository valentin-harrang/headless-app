import NextLink from 'next/link';
import { HTMLAttributes } from 'react';

interface LinkProps {
    href: string
    children?: JSX.Element | string
    props?: HTMLAttributes<HTMLLinkElement>
};

const Link = ({ href, children, ...props }: LinkProps) => {
    return (
        <NextLink href={href}>
            <a {...props}>
                {children}
            </a>
        </NextLink>
    );
}

export default Link;