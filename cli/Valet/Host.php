<?php

namespace Valet;

use Exception;
use Symfony\Component\Process\Process;

class Host
{
    var $brew, $cli, $files;

    var $resolverPath = '/etc/resolver';
    var $configPath = '/usr/local/etc/dnsmasq.conf';
    var $exampleConfigPath = '/usr/local/opt/dnsmasq/dnsmasq.conf.example';

    /**
     * Create a new DnsMasq instance.
     *
     * @param  Brew  $brew
     * @param  CommandLine  $cli
     * @param  Filesystem  $files
     * @return void
     */
    function __construct(Configuration $config, CommandLine $cli, Filesystem $files)
    {
        $this->config = $config;
        $this->cli = $cli;
        $this->files = $files;
    }

    /**
     * Install and configure DnsMasq.
     *
     * @return void
     */
    function scan()
    {
        $marker = '# Valet Custom Section';
        $hostFile = 'c:\Windows\System32\drivers\etc\hosts';
        $content = $marker.PHP_EOL;
        foreach ($this->config->read()['paths'] as $path) {
            foreach (glob($path . '/*', GLOB_ONLYDIR) as $dir) {
                $content .= '127.0.0.1 '.basename($dir).'.dev'.PHP_EOL;
            }
        }
        $content .= $marker.' END'.PHP_EOL;
        $original = file_get_contents($hostFile);
        $pattern = "/$marker.*$marker END/s";
        if (preg_match($pattern, $original)) {
            $content = preg_replace($pattern, $content, $original);
        } else {
            $content = $original.PHP_EOL.$content;
        }
        file_put_contents($hostFile, $content);
    }

    /**
     * Append the custom DnsMasq configuration file to the main configuration file.
     *
     * @param  string  $domain
     * @return void
     */
    function createCustomConfigFile($domain)
    {
        $customConfigPath = $this->customConfigPath();

        $this->copyExampleConfig();

        $this->appendCustomConfigImport($customConfigPath);

        $this->files->putAsUser($customConfigPath, 'address=/.'.$domain.'/127.0.0.1'.PHP_EOL);
    }

    /**
     * Copy the Homebrew installed example DnsMasq configuration file.
     *
     * @return void
     */
    function copyExampleConfig()
    {
        if (! $this->files->exists($this->configPath)) {
            $this->files->copyAsUser(
                $this->exampleConfigPath,
                $this->configPath
            );
        }
    }

    /**
     * Append import command for our custom configuration to DnsMasq file.
     *
     * @param  string  $customConfigPath
     * @return void
     */
    function appendCustomConfigImport($customConfigPath)
    {
        if (! $this->customConfigIsBeingImported($customConfigPath)) {
            $this->files->appendAsUser(
                $this->configPath,
                PHP_EOL.'conf-file='.$customConfigPath.PHP_EOL
            );
        }
    }

    /**
     * Determine if Valet's custom DnsMasq configuration is being imported.
     *
     * @param  string  $customConfigPath
     * @return bool
     */
    function customConfigIsBeingImported($customConfigPath)
    {
        return strpos($this->files->get($this->configPath), $customConfigPath) !== false;
    }

    /**
     * Create the resolver file to point the "dev" domain to 127.0.0.1.
     *
     * @param  string  $domain
     * @return void
     */
    function createDomainResolver($domain)
    {
        $this->files->ensureDirExists($this->resolverPath);

        $this->files->put($this->resolverPath.'/'.$domain, 'nameserver 127.0.0.1'.PHP_EOL);
    }

    /**
     * Update the domain used by DnsMasq.
     *
     * @param  string  $oldDomain
     * @param  string  $newDomain
     * @return void
     */
    function updateDomain($oldDomain, $newDomain)
    {
        $this->files->unlink($this->resolverPath.'/'.$oldDomain);

        $this->install($newDomain);
    }

    /**
     * Get the custom configuration path.
     *
     * @return string
     */
    function customConfigPath()
    {
        return $$_SERVER['HOMEPATH'].'/.valet/dnsmasq.conf';
    }
}
