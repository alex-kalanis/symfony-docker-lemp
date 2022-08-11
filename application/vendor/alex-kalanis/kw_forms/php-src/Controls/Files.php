<?php

namespace kalanis\kw_forms\Controls;


use kalanis\kw_forms\Exceptions\EntryException;
use kalanis\kw_forms\Exceptions\RenderException;
use kalanis\kw_forms\Interfaces\IMultiValue;
use kalanis\kw_input\Interfaces\IFileEntry;


/**
 * Definition of form controls Group of Files
 *
 * <b>Examples</b>
 * <code>
 * // render form for upload 5 files
 * $form = new Form();
 * $form->addFiles('fotos', 'Select files', 5);
 * echo $form;
 *
 * // render form for upload 5 files with defined labels
 * $labels = array('file 1','file 2','file 3','file 4','file 5');
 * $form = new Form();
 * $form->addFiles('fotos', $labels, 5)->setLabel('Select files');
 * echo $form;
 *
 * // render form for upload 5 files with defined labels
 * $form = new Form();
 * for($i=1;$i<6;$i++) {
 *     $files[] = new Controls\File(null, null, 'File '.$i);
 * }
 * $form->addFiles('fotos', 'Select files', $files);
 * echo $form;
 * </code>
 */
class Files extends AControl implements IMultiValue
{
    use TShorterKey;

    protected $templateLabel = '<label>%2$s</label>';
    protected $templateInput = '%3$s';

    /**
     * @param string $alias
     * @param iterable<string|int, string> $items
     * @param string $label
     * @param array<string, string|array<string>>|string $attributes
     * @return $this
     */
    public function set(string $alias, iterable $items = [], string $label = '', $attributes = []): self
    {
        $this->alias = $alias;
        $this->setLabel($label);
        foreach ($items as $key => $item) {
            $al = is_numeric($key) ? sprintf('%s[]', $alias) : sprintf('%s[%s]', $alias, strval($key));
            $this->addFile($al, $item, $attributes);
        }
        return $this;
    }

    /**
     * Add File input
     * @param string $label
     * @param string $key
     * @param array<string, string|array<string>>|string $attributes
     */
    public function addFile(string $key, string $label = '', $attributes = []): void
    {
        $formFile = new File();
        $formFile->set($key, $label)->setAttributes($attributes);
        $this->addChild($formFile);
    }

    /**
     * @param array<string, string|int|float|IFileEntry|null> $array
     */
    public function setValues(array $array = []): void
    {
        foreach ($this->children as $child) {
            if ($child instanceof File) {
                $shortKey = $this->shorterKey($child->getKey());
                $child->setValue(
                    isset($array[$shortKey])
                        // @codeCoverageIgnoreStart
                        ? $array[$shortKey] // should not happen - set prevents this
                        // @codeCoverageIgnoreEnd
                        : (
                    isset($array[$child->getKey()])
                        ? $array[$child->getKey()]
                        : ''
                    )
                );
            }
        }
    }

    /**
     * @throws EntryException
     * @return array<string, IFileEntry>
     */
    public function getValues(): array
    {
        $result = [];
        foreach ($this->children as $child) {
            if ($child instanceof File) {
                $result[$child->getKey()] = $child->getFile();
            }
        }
        return $result;
    }

    /**
     * Render all sub-controls and wrap it all
     * @throws RenderException
     * @return string
     */
    public function renderChildren(): string
    {
        $return = '';
        foreach ($this->children as $alias => $child) {
            if ($child instanceof AControl) {
                $child->setAttribute('id', $this->getAlias() . '_' . $alias);
            }

            $return .= $this->wrapIt($child->render(), $this->wrappersChild) . PHP_EOL;
        }
        return $this->wrapIt($return, $this->wrappersChildren);
    }
}
